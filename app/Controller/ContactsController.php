<?php
App::uses('AppController', 'Controller');
/**
 * Contacts Controller
 *
 * @property Contact $Contact
 */
class ContactsController extends AppController
{
    private $allowExtensions = array('jpg','png', 'gif');

    public $components = array('Paginator', 'RequestHandler');
    public $paginate = array(
        'Contact' => array(
            'limit' => 25,
            'order' => array(
                'Contact.derby_name' => 'asc',
                'Contact.name' => 'asc'
            )
        )
    );

    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->Auth->allow(array('login', 'add'));
    }

    /**
     * @todo implment
     */
    public function get_login_url()
    {

    }

    public function logout()
    {
        $params = array( 'next' => Router::url('/', true) );
        $fbLogout = $this->Facebook->getLogoutUrl($params);

        $this->Auth->logout();

        $this->redirect($fbLogout);
    }

    public function login()
    {
        if (!empty($this->request->query['code'])) {
            $query = $this->request->query;

            App::uses('HttpSocket', 'Network/Http');

            $HttpSocket = new HttpSocket();

            $results = $HttpSocket->get('https://graph.facebook.com/oauth/access_token', array(
                'client_id' => Configure::read('Facebook.appId'),
                'redirect_uri' => Router::url(array('controller' => 'contacts', 'action' => 'login'), true),
                'client_secret' => Configure::read('Facebook.secret'),
                'code' => $query['code']
            ));

            if ($results->code == '200') {
                $responseParts = explode("&", $results->body);
                $organizedResponse = array();

                foreach ($responseParts as &$part) {
                    $part = explode("=", $part);
                    $organizedResponse[$part[0]] = $part[1];
                }

                $this->Session->write('FBAccessToken', $organizedResponse['access_token']);

                //Are they a user yet?
                try {
                    $this->Facebook->setAccessToken($this->Session->read('FBAccessToken'));
                    $fbUser = $this->Facebook->api('/me');
                } catch (Exception $e) {
                    $this->redirect('/');
                }

                $contact = $this->Contact->find('first', array(
                    'conditions' => array(
                        'Contact.facebook_id' => $fbUser['id']
                    )
                ));

                if ($contact) {
                    $this->Auth->login($contact['Contact']);
                    $this->redirect(array('action' => 'index'));
                }

                $this->redirect(array('action' => 'add'));
            } else {
                $this->redirect(array('action' => 'login'));
            }

            /**
             * @todo Check For Error
             */


            exit;
        }
    }

    public function logged_in_user()
    {
        if (!$this->loggedIn) {
            $userProfile = array('success' => false);
        } else {
            $uid = $this->Facebook->getUser();
            $userProfile = $this->Facebook->api('/me', 'GET');

            $userProfile['local_user'] = $this->Contact->find('count', array('conditions' => array('facebook_id' => $uid))) > 0 ? true : false;
            $userProfile['success'] = true;
        }

        $this->set(array(
            'userProfile' => $userProfile
        ));
    }

    public function index()
    {
        $this->Paginator->settings = $this->paginate;
        if (!empty($this->request->params['named']['role_id']) && $this->request->params['named']['role_id'] != '%') {
            $conditions = array('(SELECT COUNT(*) FROM contacts_roles cr WHERE cr.role_id=? AND cr.contact_id=Contact.id) > 0' => array($this->request->params['named']['role_id']));
            $roleId = $this->request->params['named']['role_id'];
        } else {
            $conditions = array();
            $roleId = '%';
        }

        $contacts =  $this->Paginator->paginate('Contact', $conditions);
        $this->set(array(
            'contacts' => $contacts
        ));

        $this->set('roles', $this->Contact->Role->find('list'));
        $this->set('currentRoleId', $roleId);
    }

    public function view($id)
    {
        $contact = $this->Contact->findById($id);
        $this->set(array(
            'contact' => $contact
        ));
    }

    public function user_exists($id)
    {
        $contact = $this->Contact->find('first', array(
            'condition' => array('facebook_id' => $id)
        ));
        $this->set(array(
            'contact' => $contact
        ));
    }

    public function add()
    {
        $data = $this->request->input('json_decode');

        if ($data) {
            $postData = array('Contact' => array());

            foreach ($data->contact as $key => $value) {
                $postData['Contact'][$key] = $value;
            }

            if (!$this->Contact->validates()) {
                $message = 'Error - Validation Failed';
                $success = false;
            } else {
                if ($this->Contact->save($postData)) {
                    $message = 'Saved';
                    $success = true;
                } else {
                    $message = 'Error Saving';
                    $success = false;
                }
            }
            $this->set(array(
                'response' => array('message' => $message, 'success' => $success)
            ));
        }

        try {
            $this->Facebook->setAccessToken($this->Session->read('FBAccessToken'));
            $fbUser = $this->Facebook->api('/me', 'GET', array('fields' => 'id,name,username,link,picture'));
        } catch (Exception $e) {
            $this->redirect('/');
        }

        $this->set('fbUser', $fbUser);

        if (!empty($this->request->data)) {
            $data = $this->request->data;
            $data['Contact']['password'] = AuthComponent::password(uniqid(md5(mt_rand())));

            $data = $this->manageProfilePic($data);

            $this->Contact->save($data);

            $data['Contact']['id'] = $this->Contact->id;

            $this->Auth->login($data['Contact']);

            $this->redirect(array('action' => 'index'));
        }

        if (empty($this->request->data)) {
            $this->request->data = array(
                'Contact' => array(
                    'name' => $fbUser['name'],
                    'facebook_link' => $fbUser['link'],
                    'facebook_id' => $fbUser['id'],
                    'username' => $fbUser['username']
                )
            );
        }

        $this->set('roles', $this->Contact->Role->find('list'));
        $this->set('organizations', $this->Contact->Organization->find('list'));
    }

    public function edit()
    {
        try {
            $this->Facebook->setAccessToken($this->Session->read('FBAccessToken'));
            $fbUser = $this->Facebook->api('/me', 'GET', array('fields' => 'id,name,username,link,picture'));
        } catch (Exception $e) {
            $this->redirect('/');
        }

        $this->set('fbUser', $fbUser);

        $data = $this->request->input('json_decode');

        if ($data) {
            $postData = array('Contact' => array());

            foreach ($data->contact as $key => $value) {
                $postData['Contact'][$key] = $value;
            }

            if (!$this->Contact->validates()) {
                $message = 'Error - Validation Failed';
                $success = false;
            } else {
                if ($this->Contact->save($postData)) {
                    $message = 'Saved';
                    $success = true;
                } else {
                    $message = 'Error Saving';
                    $success = false;
                }
            }
            $this->set(array(
                'response' => array('message' => $message, 'success' => $success)
            ));
        }

        if (!empty($this->request->data)) {
            $this->request->data['Contact']['id'] = $this->Auth->user('id');

            $data = $this->manageProfilePic($this->request->data, false);

            $this->Contact->save($data);

            $this->redirect(array('action' => 'index'));
        }

        if (empty($this->request->data)) {
            $this->request->data = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Auth->user('id'))));
        }

        $this->set('roles', $this->Contact->Role->find('list'));
        $this->set('organizations', $this->Contact->Organization->find('list'));
    }

    /**
     * @todo Delete Old if it exists, check the id ?
     * @param $data
     * @param bool $default
     * @return mixed
     */
    private function manageProfilePic ($data, $default = true)
    {
        try {
            $this->Facebook->setAccessToken($this->Session->read('FBAccessToken'));
            $fbUser = $this->Facebook->api('/me', 'GET', array('fields' => 'id,name,username,link,picture'));
        } catch (Exception $e) {
            $this->redirect('/');
        }

        if ($data['Contact']['use_facebook_pic'] == '0') {
            if (
                isset($data['Contact']['profile_pic']['tmp_name'])
                && is_uploaded_file($data['Contact']['profile_pic']['tmp_name'])
                && in_array(strtolower(pathinfo($data['Contact']['profile_pic']['name'], PATHINFO_EXTENSION)), $this->allowExtensions)
            ) {
                $tmpName = tempnam(WWW_ROOT.'files', 'profile_').'.'.strtolower(pathinfo($data['Contact']['profile_pic']['name'], PATHINFO_EXTENSION));
                if (move_uploaded_file($data['Contact']['profile_pic']['tmp_name'], $tmpName)) {

                    $image = new Gmagick($tmpName);
                    $image->thumbnailImage(50,50);
                    $image->write($tmpName);

                    $data['Contact']['profile_pic'] = Router::url('/files/'.basename($tmpName), true);
                } else {
                    $data['Contact']['profile_pic'] = false;
                }
            } else {
                $data['Contact']['profile_pic'] = false;
            }
        } else {
            $tmpName = tempnam(WWW_ROOT.'files', 'profile_').'.'.strtolower(pathinfo($fbUser['picture']['data']['url'], PATHINFO_EXTENSION));
            if (file_put_contents($tmpName, file_get_contents($fbUser['picture']['data']['url']))) {
                $data['Contact']['profile_pic'] = Router::url('/files/'.basename($tmpName), true);
            } else {
                $data['Contact']['profile_pic'] = false;
            }
        }

        if (!$data['Contact']['profile_pic']) {
            if ($default) {
                $data['Contact']['profile_pic'] = Router::url('/img/default-user.png', true);
            } else {
                unset($data['Contact']['profile_pic']);
            }
        }

        return $data;
    }

    public function delete($id)
    {
        if ($this->Contact->delete($id, false)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}

<?php
App::uses('AppController', 'Controller');
/**
 * Contacts Controller
 *
 * @property Contact $Contact
 */
class ContactsController extends AppController
{

    /**
     * Components
     * @access public
     */
    public $components = array('RequestHandler');

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
                    $this->redirect(array('action' => 'login'));
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
        $contacts = $this->Contact->find('all');
        $this->set(array(
            'contacts' => $contacts
        ));
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
            $this->request->data['Contact']['password'] = AuthComponent::password(uniqid(md5(mt_rand())));
            $this->Contact->save($this->request->data);

            $this->Auth->login($this->request->data['Contact']);

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
            $this->Contact->save($this->request->data);

            $this->redirect(array('action' => 'index'));
        }

        if (empty($this->request->data)) {
            $this->request->data = $this->Contact->find('first', array('conditions' => array('Contact.id' => $this->Auth->user('id'))));
        }
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

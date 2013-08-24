<?php
App::uses('AppController', 'Controller');
/**
 * Contacts Controller
 *
 * @property Contact $Contact
 */
class ContactsController extends AppController {
	
/**
 * Components
 * @access public
 */
	public $components = array('RequestHandler');

    public function get_login_url()
    {
        $params = array(
            'scope' => 'read_stream, friends_likes',
            'redirect_uri' => 'http://derbycontact.com/contacts/login_complete.json'
        );

        $this->set(array(
            'loginUrl' => $this->Facebook->getLoginUrl($params)
        ));
    }

    public function login_complete()
    {

        $query = $this->request->query;

        App::uses('HttpSocket', 'Network/Http');

        $HttpSocket = new HttpSocket();

        $results = $HttpSocket->get('https://graph.facebook.com/oauth/access_token', array(
            'client_id' => Configure::read('Facebook.appId'),
            'redirect_uri' => 'http://derbycontact.com/contacts/login_complete.json',
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

            /**
             * @todo redirect somewhere
             */
            exit;
        }

        /**
         * @todo Check For Error
         */


        exit;
    }

    public function logged_in_user()
    {
        $uid = $this->Facebook->getUser();
        $userProfile = $this->Facebook->api('/me','GET');

        $userProfile['local_user'] = $this->Contact->find('count', array('conditions' =>  array('facebook_id' => $uid))) > 0 ? true : false;

        $this->set(array(
            'userProfile' => $userProfile
        ));
    }

	public function index() {
        $contacts = $this->Contact->find('all');
        $this->set(array(
            'contacts' => $contacts
        ));
	}

   public function view($id) {
        $contact = $this->Contact->findById($id);
        $this->set(array(
            'contact' => $contact
        ));
    }

    public function user_exists($id) {
        $contact = $this->Contact->find('first', array(
            'condition' => array('facebook_id' => $id)
        ));
        $this->set(array(
            'contact' => $contact
        ));
    }
	
    public function add() {
	  $data = $this->request->input('json_decode');
	  
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

    public function edit() {
	  $data = $this->request->input('json_decode');
	  
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

    public function delete($id) {
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

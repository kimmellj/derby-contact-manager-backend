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

/**
 * index method
 *
 * @return void
 */
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

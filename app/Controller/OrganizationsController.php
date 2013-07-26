<?php
App::uses('AppController', 'Controller');
/**
 * Organizations Controller
 *
 * @property Organization $Organization
 */
class OrganizationsController extends AppController {
	
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
        $organizations = $this->Organization->find('all', array('contain'=>false));
        $this->set(array(
            'organizations' => $organizations
        ));
	}
	
/**
 * list method
 *
 * @return void
 */
	public function indexList() {
        $organizations = $this->Organization->find('all', array('contain' => false, 'fields' => array('id', 'name')));
        $this->set(array(
            'organizations' => $organizations
        ));
	}	

   public function view($id) {
		$this->Organization->contain();
        $organization = $this->Organization->findById($id);
        $this->set(array(
            'organization' => $organization
        ));
    }
	
    public function add() {
	  $data = $this->request->input('json_decode');
	  
	  $postData = array('Organization' => array());
	  
	  foreach ($data->organization as $key => $value) {
	       $postData['Organization'][$key] = $value;
	  }
	  
	  if ($this->Organization->save($postData)) {
	      $message = 'Saved';
	      $success = true;
	  } else {
	      $message = 'Error - '.join("<br />", $this->Organization->validationErrors);
	      $success = false;
	  }
	  $this->set(array(
	      'response' => array('message' => $message, 'success' => $success)
	  ));
    }	

    public function edit() {
	  $data = $this->request->input('json_decode');
	  
	  $postData = array('Organization' => array());
	  
	  foreach ($data->organization as $key => $value) {
	       $postData['Organization'][$key] = $value;
	  }
	  
	  if (!$this->Organization->validates()) {
	      $message = 'Error - Validation Failed';
	      $success = false;		
	  } else {
		if ($this->Organization->save($postData)) {
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
        if ($this->Organization->delete($id)) {
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

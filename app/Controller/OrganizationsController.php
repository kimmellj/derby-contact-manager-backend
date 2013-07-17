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
        $organizations = $this->Organization->find('all');
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
        $organizations = $this->Organization->find('list');
        $this->set(array(
            'organizations' => $organizations
        ));
	}	

   public function view($id) {
        $organization = $this->Organization->findById($id);
        $this->set(array(
            'organization' => $organization
        ));
    }

    public function edit($id) {
        $this->Organization->id = $id;
        if ($this->Organization->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
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

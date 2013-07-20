<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 */
class RolesController extends AppController {
	
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
        $roles = $this->Role->find('all');
        $this->set(array(
            'roles' => $roles
        ));
	}
	
/**
 * list method
 *
 * @return void
 */
	public function indexList() {
        $roles = $this->Role->find('list');
        $this->set(array(
            'roles' => $roles
        ));
	}	

   public function view($id) {
        $role = $this->Role->findById($id);
        $this->set(array(
            'role' => $role
        ));
    }

    public function edit($id) {
        $this->Role->id = $id;
        if ($this->Role->save($this->request->data)) {
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
        if ($this->Role->delete($id)) {
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

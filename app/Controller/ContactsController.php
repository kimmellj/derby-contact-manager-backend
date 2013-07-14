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
            'contacts' => $contacts,
        ));
	}

   public function view($id) {
        $contact = $this->Contact->findById($id);
        $this->set(array(
            'contact' => $contact,
            '_serialize' => array('contact')
        ));
    }

    public function edit($id) {
        $this->Contact->id = $id;
        if ($this->Contact->save($this->request->data)) {
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
        if ($this->Contact->delete($id)) {
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

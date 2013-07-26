<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property Contact $Contact
 */
class Role extends AppModel {

	public $displayField = 'name';
    
    public $actsAs = array('Containable');
    
    public $order = array('name');


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'role_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}

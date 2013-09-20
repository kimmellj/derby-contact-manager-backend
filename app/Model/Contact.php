<?php
App::uses('AppModel', 'Model');
/**
 * Contact Model
 *
 * @property Organization $Organization
 */
class Contact extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule'       => array('notempty'),
                'message'    => 'The contact name must be entered.',
                'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Organization' => array(
            'className' => 'Organization',
        ),
        'Role'         => array(
            'className' => 'Role',
        ),
    );

    public function beforeSave($options = array())
    {
        foreach ($this->data['Organization']['Organization'] as &$organization) {
            if ($organization == 1 && !empty($this->data['Contact']['other_organization'])) {
                $this->Organization->create();
                $this->Organization->save(array(
                    'Organization' => array(
                        'name' => $this->data['Contact']['other_organization']
                    )
                ));
                $organization = $this->Organization->id;
            }
        }

        return true;
    }
}

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
    
    public $actsAs = array('Containable');
    
    /**
     * Is the user looking at this model verified?
     *
     * @var boolean
     */
    public $verifiedViewer = false;

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
     *hasMany associations
     *
     *@var array
     */
    public $hasMany = array('AuthorizedContact');
    
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
    
    public function afterFind($results, $primary = false)
    {
        if (!$this->verifiedViewer) {
            foreach ($results as $key => $value) {
                $value['Contact']['name'] = '';
                $value['Contact']['phone'] = '';
                $value['Contact']['email'] = '';
                $value['Contact']['address'] = '';
                $value['Contact']['city'] = '';
                $value['Contact']['state'] = '';
                $value['Contact']['zip'] = '';
                $value['Contact']['facebook_link'] = '';
                
                $results[$key] = $value;
            }
        }
        
        return $results;
    }
}

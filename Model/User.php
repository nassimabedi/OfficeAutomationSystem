<?php

// app/Model/User.php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {

    public $name = 'User';
    public $virtualFields = array('full_name' => 'CONCAT(first_name, " ", last_name)');
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'officer','staff','manager')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );

    public $belongsTo = array(
    'Departments' => array(
        'className'    => 'Departments',
        'foreignKey'   => 'department_id'
    ));

    public $hasMany = array(
        'Shifts' => array(
            'className'     => 'Shifts',        
        ),    
        'Missions' => array(
            'className'     => 'Missions',        
        )    
    );

    public function beforeSave() {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

}

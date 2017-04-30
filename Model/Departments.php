<?php

class Departments extends AppModel {
	var $useTable = "departments";
    public $actsAs = array('Containable');
	
    public $hasMany = array(
    'User' => array(
        'className'     => 'User',
    )


);
	
}


?>

<?php

require_once 'MainController.php';
class ManagersController extends MainController {
	public $scaffold;
	public $helpers = array('Html', 'Form','Js');
	public $uses = array('Departments');

	function beforeFilter() {        
        parent::beforeFilter();
        if (isset($this->userDetails['role']) && $this->userDetails['role'] !='manager') {
        	die('You do not have access to this page.');
        }        
    }

	function index() {
		$departments = $this->Departments->find('list');		
	}
	
    function getShifts () {            
        $user_id = $_REQUEST['user_id'];        
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];     
        
        $conditions = array('User.department_id' => $this->userDetails['department_id'],
                            'Shifts.disabled'=>0 );

        if ($user_id) {
            $conditions ['Shifts.user_id'] = $user_id;
        }

        if ($start_date) {
            $conditions['Shifts.date >='] = $start_date;
        }

        if ($end_date) {
            $conditions['Shifts.date <='] = $end_date;
        }  

        $this->getShiftsComplete($conditions);  
    }

	

    function getMissions() {   
        $user_id = $_REQUEST['user_id'];        
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date']; 
        
        $conditions = array('User.department_id' => $this->userDetails['department_id'],
                            'Missions.disabled'=>0);

        if ($user_id) {
            $conditions ['Missions.user_id'] = $user_id;
        }

        if ($start_date) {
            $conditions['Missions.date >='] = $start_date;
        }

        if ($end_date) {
            $conditions['Missions.date <='] = $end_date;
        }

        $this->getMissionsComplete($conditions);
    }


    function missionInsert () {  
        $user_id = $_REQUEST['user_id'];
        $this->request->data['Missions']['user_id'] = $user_id;        
        $this->missionInsertComplete();                   
    }   

    function getMission() {
        $this->loadModel('Missions'); 
        $this->Missions->id = $this->params['url']['rec_id'];
        $conditions =  array('Missions.id'=>$this->Missions->id);
        $this->getMissionComplete($conditions); 
    }

    function missionUpdate() {
        $user_id = $_REQUEST['user_id'];
        $this->request->data['Missions']['user_id'] = $user_id;  
        $this->missionUpdateComplete();       
    }

	function shiftInsert () {        
        $this->loadModel('User');   
        $this->loadModel('Shifts');   
        $user_id = $_GET['user_id'];
        $this->request->data['Shifts']['user_id'] = $user_id;
        $this->shiftInsertComplete();              
            
    }

    function getShift() {
        $this->loadModel('Shifts'); 
        $conditions = array('Shifts.id'=>$this->params['url']['rec_id']);
        $this->getShiftComplete($conditions);               
    }

    function shiftUpdate () {        
        $this->loadModel('Shifts');              
        $user_id = $_GET['user_id'];
        $this->request->data['Shifts']['user_id'] = $user_id;
        $this->shiftUpdateComplete();
    }

   function approveMission () {
            
        $this->loadModel('Missions');          
        $this->request->data['Missions']['id'] = $_REQUEST['id'];
        $this->request->data['Missions']['approve'] = $_REQUEST['approve'];                
        if ($this->Missions->save($this->request->data)) {           
	    die('done');
        } else {        
        }        
        die('done');

   } 

   function approveShift () {
	
            
        $this->loadModel('Shifts');          
        $rec_id = trim($_REQUEST['id']);
	$approve = trim($_REQUEST['approve']);
	if ($approve) {
		$sql = "UPDATE shifts SET approved_overtime=overtime,approve='1' WHERE id='$rec_id'";
	} else {
		$sql = "UPDATE shifts SET approved_overtime='',approve='0' WHERE id='$rec_id'";
	}

                           
        if ($this->Shifts->query($sql)) {                       
		die('done'); 
        } else {        
		die('has error');
        }        
        die;

    } 	

}


?>

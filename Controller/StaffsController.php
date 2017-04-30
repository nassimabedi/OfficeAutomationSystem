<?php

require_once 'MainController.php';

class StaffsController extends MainController {
	public $scaffold;
	public $helpers = array('Html', 'Form','Js');
	

	function beforeFilter() {        
        parent::beforeFilter();
        if (isset($this->userDetails['role']) && $this->userDetails['role'] !='staff') {
        	die('You do not have access to this page.');
        }        
    }
    
	function index() {	
        
	}	

    function getShifts () {                        
        $conditions = array('Shifts.user_id' => $this->userDetails['id'],'Shifts.disabled'=>0);
        $this->getShiftsComplete($conditions); 
    }
  

    function shiftInsert () {        
        $this->loadModel('User');   
        $this->loadModel('Shifts');          
        $this->request->data['Shifts']['user_id'] = $this->userDetails['id'];
        $this->shiftInsertComplete();               
    }
   

    function getMissions() {       

        $conditions = array('Missions.user_id' => $this->userDetails['id'],'Missions.disabled'=>0);

        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
	$mission_type = $_REQUEST['mission_type'];

        if ($start_date) {
            $conditions['Missions.date >='] = $start_date;
        }

        if ($end_date) {
            $conditions['Missions.date <='] = $end_date;
        }
	if ($mission_type) {
            $conditions['Missions.type'] = $mission_type;

        }


        $this->getMissionsComplete($conditions);        
    }

    function missionInsert () {          
        $this->request->data['Missions']['user_id'] = $this->userDetails['id'];
        $this->missionInsertComplete();       
    }

    function getMission() {
        $this->Missions->id = $this->params['url']['rec_id'];
        $conditions = array('Missions.user_id' => $this->userDetails['id'],'Missions.id'=>$this->params['url']['rec_id']);
        $this->getMissionComplete($conditions);         
    }

    function missionUpdate() {
        $this->request->data['Missions']['user_id'] = $this->userDetails['id']; 
        $this->missionUpdateComplete();        
    }

    function getShift() {
        $this->loadModel('Shifts'); 
        $conditions = array('Shifts.user_id' => $this->userDetails['id'],'Shifts.id'=>$this->params['url']['rec_id']);
        $this->getShiftComplete($conditions);            
    }

    function shiftUpdate () {
        
        $user_id = $this->userDetails['id'];
        $this->request->data['Shifts']['user_id'] = $user_id;
        $this->shiftUpdateComplete();        
    }   
	
}

?>


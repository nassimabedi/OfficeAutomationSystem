<?php
App::uses('AppController', 'Controller');

App::uses('Lib','DatabaseLogger');
App::import('Vendor','pdate');


class MainController extends AppController {
	public $uses = array('Department');

	public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);        
        App::import('Model', 'ConnectionManager');
        $conn = ConnectionManager::getDataSource('default');
        $this->conn_crm = ConnectionManager::getDataSource('crm');
        $this->conn = $conn;        
    }

    public function beforeFilter() {
        parent::beforeFilter();        
        // remove leading and trailing whitespace from posted data
        if (!function_exists('trimItem')) {
            function trimItem(&$item,$key){
                if (is_string($item)){        
                    $item = addslashes(trim($item));    
                }
            }
        }       
        array_walk_recursive($this->request->data, 'trimItem'); 
    }

	function getAllDepartments() {		
		$this->loadModel('Departments');
		$this->Departments->recursive = -1;		
		$departments = $this->Departments->find('all',array(
															  'recursive' => -1,															 
															  'conditions'=>array('Departments.disabled' => 0)));

		$json_response = json_encode($departments);
        echo $json_response;	
        die;	
	}


	function getAllUsers() {		
		$this->loadModel('User');
		$this->User->recursive = -1;		
		$users = $this->User->find('all',array(
											  'recursive' => -1,															 
											  'conditions'=>array('User.disabled' => 0)));

		$json_response = json_encode($users);
        echo $json_response;	
        die;	
	}

	function getUsers() {		
		$this->loadModel('User');
		$this->User->recursive = -1;		
		$users = $this->User->find('all',array(
											  'recursive' => -1,															 
											  'conditions'=>array('User.disabled' => 0,
											  					  'User.department_id'=>$this->userDetails['department_id'])));

		$json_response = json_encode($users);
        echo $json_response;	
        die;	
	}

	function getGregorianDate($date_time) {
		list($date, $time) = explode(' ', $date_time);    
        return jal2grn($date) . " $time:0";
	}

	function getJalaliDate($date_time) {
        
		list($date, $time) = explode(' ', $date_time);    
        return grn2jal($date,'Y / m /d') . " $time:0";
	}
	function getJalaliDateTime($date_time) {
		list($date, $time) = explode(' ', $date_time);            
        return array(grn2jal($date),
        			  "$time:0");
	}

	function getJalali($date) {
		return grn2jal($date,'Y / m /d');
	}
	function trimData($data) {
		return trim($data);

	}

	function getLeaveTime() {
        $this->loadModel('Settings');            
        $this->Settings->id = 1;       
        $setting = $this->Settings->find('all', array('fields' => array('id','leave_time'),
                                                        'conditions' => array('Settings.id' => $this->Settings->id)
                                                    ));
        
        
        //$setting[0]['Settings']['leave_time'] = date('Y-m-d') .' '.$setting[0]['Settings']['leave_time'];
        $setting[0]['Settings']['leave_time'] = $setting[0]['Settings']['leave_time'];
        $json_response = json_encode($setting[0]);
        echo $json_response;
        die;
    }

    function insertShiftServices($services,$shift_id) {
    	$this->loadModel('ShiftServices');   
    	$this->request->data['ShiftServices']['shift_id'] = $shift_id;    	
    	$this->request->data['ShiftServices']['customer'] = $services['customer'];
    	$this->request->data['ShiftServices']['ticket_num'] = $services['ticket_num'];
        $this->request->data['ShiftServices']['description'] = $services['description'];
        $this->request->data['ShiftServices']['issue_details'] = $services['issue_details'];
        $this->request->data['ShiftServices']['contact_name'] = $services['contact_name'];
        $this->request->data['ShiftServices']['start_date'] = $services['start_date'];
    	$this->request->data['ShiftServices']['end_date'] = $services['end_date'];
    	$this->ShiftServices->create();    	

        if ($this->ShiftServices->save($this->request->data)) {                
             //die('رکود با موفقیت ثبت شد');
        } else {
            //die('خطایی در ثبت رکورد وجود دارد');
        }
    	

    }

    function getShiftServices($shift_id) {
    	$this->loadModel('ShiftServices');
		$this->User->recursive = -1;		
		$shift_service = $this->ShiftServices->find('all',array(
											  'conditions'=>array('shift_id'=>$shift_id)));


		$shift_service = Set::extract('/ShiftServices/.', $shift_service);
		
		return $shift_service;		
    }
    

    function deleteShiftService($shift_id) {
    	$this->loadModel('ShiftServices');   	
    	$this->ShiftServices->deleteAll(array('ShiftServices.shift_id' => $shift_id), false);    	    	
    }

	
    function get_csv_report($func_name,$start_date,$end_date,$str) {         
            	
        $csv_name = $func_name. '_' . $start_date .'_'. $end_date ;
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $csv_name . '.csv"');
        header('Content-Transfer-Encoding: Binary');

        $func_name = $func_name . '_computation';
        

        $str = html_entity_decode($str, ENT_NOQUOTES, 'utf-8');
        $str = chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE", $str);
        header('Content-Length: ' . strlen($str));
        echo $str;
        exit;
    }

    function fileUpload() {

        $type = $this->trimData($_GET['type']);
                
        $target_dir = "files/".$type."/";        
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES['file']['tmp_name'],$target_file);  


        die('File upload.');
    }

    function getAccounts() {                    
        $sql = "SELECT name FROM accounts WHERE deleted='0' LIMIT 0,10";          
        //$sql = "SELECT name FROM accounts WHERE deleted='0'";          
        $accounts = $this->conn_crm->query($sql);                          
        echo json_encode($accounts);
        die;        
    }

    function getStartOverTime() {
        $this->loadModel('Settings');            
        $this->Settings->id = 1;       
        $setting = $this->Settings->find('all', array('fields' => array('id','leave_time'),
                                                        'conditions' => array('Settings.id' => $this->Settings->id)
                                                    ));
        
                
        return $setting[0]['Settings']['leave_time'];

    }

    function shiftList () {             
    }


    function shiftAdd () {

    }

    function shiftEdit() {        

    }

    function missionList () {           

    }

    function missionAdd () {  

    }

    function missionEdit() {        
    }

    function missionDelete() {

        $id = $this->trimData($_REQUEST['id']);
        $this->loadModel('Missions');  

        $this->request->data['Missions']['id'] = $id;
        $this->request->data['Missions']['disabled'] = 1;        
        
        if ($this->Missions->save($this->request->data)) {            
            die;
            return true;
        } else {        
            return false ;  
        }        
        die;
    }

    function shiftDelete() {

        $id = $this->trimData($_REQUEST['id']);
        $this->loadModel('Shifts');  

        $this->request->data['Shifts']['id'] = $id;
        $this->request->data['Shifts']['disabled'] = 1;        
        
        if ($this->Shifts->save($this->request->data)) {            
            die;
            return true;
        } else {        
            return false ;  
        }        
        die;
    }
   

    function missionInsertComplete() {        
        $this->loadModel('Missions'); 
        $date = $_REQUEST['date'];
        $customer_name = $_REQUEST['customer_name'];
        $mission_type = $_REQUEST['mission_type'];
        $purpose = $_REQUEST['purpose'];
        $start_time = $_REQUEST['start_time'];
        $end_time = $_REQUEST['end_time'];
        $description = $_REQUEST['description'];  
        $file_name = $_GET['file_name']; 

        $this->loadModel('Missions');              
        //$this->request->data['Missions']['user_id'] = $this->userDetails['id'];        
        $mission = $this->request->data['Missions'];
        $mission['date'] = $date;  
        $mission['customer_name'] = $_REQUEST['customer_name'];
        $mission['type'] = $mission_type;
        $mission['purpose'] = $_REQUEST['purpose'];                                                       
        $mission['start_time'] = $start_time;                                                                        
        $mission['end_time'] = $end_time;        

       
        if ( $mission_type == 'برون شهری') {             
            $days = getMissionDays($start_time,$end_time);        
            $mission['days'] = $days;            

        } else {
            $mission['hours'] = get_diff_time($end_time,$start_time);             
        }
        
        $mission['description'] = $description; 
        $mission['file_name'] = $file_name;
        $this->request->data['Missions'] = $mission ;

        $this->Missions->create();


        if ($this->Missions->save($this->request->data)) {   
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }        
        die();

    }


    function missionUpdateComplete() {
        $this->loadModel('Missions');           
        $date = $_REQUEST['date'];
        $customer_name = $_REQUEST['customer_name'];
        $mission_type = $_REQUEST['mission_type'];
        $purpose = $_REQUEST['purpose'];
        $start_time = $_REQUEST['start_time'];
        $end_time = $_REQUEST['end_time'];
        $description = $_REQUEST['description']; 
	
        $file_name = $_REQUEST['file_name'];        
        $id = $_REQUEST['id'];             
        $this->loadModel('Missions');   
        $mission = $this->request->data['Missions'];
        $mission['id'] = $id;
        //$this->request->data['Missions']['user_id'] = $this->userDetails['id'];        
        $mission['date'] = $date;  
        $mission['customer_name'] = $_REQUEST['customer_name'];
        $mission['type'] = $mission_type;
        $mission['purpose'] = $_REQUEST['purpose'];                                                       
        $mission['start_time'] = $start_time;                                                                        
        $mission['end_time'] = $end_time;  
         if ( $mission_type == 'برون شهری') {             
             $days = getMissionDays($start_time,$end_time);        
             $mission['days'] = $days;            

        } else {
            $mission['hours'] = get_diff_time($end_time,$start_time);             
        }                                                                                      
        $mission['description'] = $description; 
	$mission['approve'] = isset($_REQUEST['approve']) ? $_REQUEST['approve'] : '';
        $mission['file_name'] = $file_name; 
           
        $this->request->data['Missions'] = $mission;

        if ($this->Missions->save($this->request->data)) {            
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }

    }

   function getMissionComplete($conditions) {  
        $this->loadModel('Missions');                 
        $result = $this->Missions->find('first', array('conditions' => $conditions));                          
        $mission = $result['Missions'];

        if ($mission['date']) {            
            $mission['date'] = $mission['date'];                
        }
        if ($mission['start_time']) {            
            list($start_date,$start_time) = explode(" ", $mission['start_time']);
            $mission['start_date'] = $start_date;
            $mission['start_time'] = $mission['start_time'];                
        }        
        if ($mission['end_time']) {
            list($end_date,$end_time) = explode(" ", $mission['end_time']);
            $mission['end_date'] = $end_date;
            $mission['end_time'] = $mission['end_time'];                
        }         

        $result['Missions'] = $mission;        
        $json_response = json_encode($result);
        echo $json_response;
        die;           
   }

   function getMissionsComplete ($conditions) {
        $this->loadModel('Missions');   
        $curr_page = $this->trimData($_GET['curr_page']);
        $limit = $this->trimData($_GET['limit']) ;        
        $offset = ($curr_page - 1) * $limit;         

        $total = $this->Missions->find('count', array(
                                                'conditions' => $conditions,                                                
                                                ));           


        $sum = $this->Missions->find('all', array(                                                  
                                                  'fields' => array('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, start_time,end_time ))) AS hours_sum','SUM(days) AS days'),
                                                  'conditions' => $conditions,                                                        
                                                    ));         

        $missions = $this->Missions->find('all', array(
                                                'conditions' => $conditions,
                                                'offset' => $offset,
                                                'limit' => $limit,
                                                'order' => 'Missions.date DESC'
                                            ));

        $json_response = json_encode(array('data'=>$missions,'total'=>$total,'curr_page'=>(int)$curr_page,'hours_sum'=> $sum[0][0]['hours_sum'],'days_sum'=>$sum[0][0]['days']));        
        echo $json_response;
        die;
   }

   function getShiftsComplete($conditions) {   
     $this->loadModel('Shifts');
     $curr_page = $_GET['curr_page'];
     $limit = $_GET['limit'];        
     $offset = ($curr_page - 1) * $limit; 


     $total = $this->Shifts->find('count',array('conditions'=>$conditions));
     $sum = $this->Shifts->find('all', array(            
        'fields' => array('sum(Shifts.approved_overtime) AS approved_overtime_sum',
                          'SEC_TO_TIME(SUM(TIME_TO_SEC(overtime))) AS overtime_sum',
                          'SEC_TO_TIME(SUM(TIME_TO_SEC(approved_overtime))) AS approved_overtime_sum'),
        'conditions' => $conditions
            ) );
      $shifts = $this->Shifts->find('all', array(
                                            'conditions' => $conditions,
                                            'offset' => $offset,
                                            'limit' => $limit,
                                            'order' => 'Shifts.date DESC'
                                            ));

      $json_response = json_encode(array('data'=>$shifts,'total'=>$total,'curr_page'=>(int)$curr_page,
                                        'overtime_sum'=> $sum[0][0]['overtime_sum'],
                                        'approved_overtime_sum'=> $sum[0][0]['approved_overtime_sum'],
                                        ));        
      echo $json_response;
      die;     
   }

   function shiftInsertComplete () {

        $shift_services = $_GET['services'];        
        
        $date = $_GET['date'];
        $exit_hour = $_GET['exit_hour'];
        $delivery_hour = $_GET['delivery_hour'];
        $all_calls_num = $_GET['all_calls_num'];
        $successfull_calls_num = $_GET['successfull_calls_num'];
        $unsuccessfull_calls_num = $_GET['unsuccessfull_calls_num'];
        $after_shift_start_time = $_GET['after_shift_start_time'];
        $after_shift_end_time = $_GET['after_shift_end_time'];
        $overtime = $_GET['overtime'];
        $send_shift_report = $_GET['send_shift_report'];
       
        $shift = $this->request->data['Shifts'];
        $file_name = $this->trimData($_GET['file_name']);
        if ($date) {             
            $shift['date'] = $date;
        }

        if ($exit_hour) {            
            $shift['exit_hour'] = $exit_hour;
        }
        if ($delivery_hour) {            
            $shift['delivery_hour'] = $delivery_hour;
        }        
        if ($after_shift_start_time) {            
            $shift['after_shift_start_time'] = $after_shift_start_time;
        }
        if ($after_shift_end_time) {            
            $shift['after_shift_end_time'] = $after_shift_end_time;
        }
        if ($send_shift_report) {
            $shift['send_shift_report'] = 1;
        } else {
            $shift['send_shift_report'] = 0;
        }
        $shift['all_calls_num'] = $all_calls_num;
        $shift['successfull_calls_num'] = $successfull_calls_num;
        $shift['unsuccessfull_calls_num'] = $unsuccessfull_calls_num;
        $shift['overtime'] = $overtime;
        $shift['file_name'] = $file_name;        
        $shift['description'] = $this->trimData($_GET['description']);
       
        $this->request->data['Shifts'] = $shift;
        $this->Shifts->create();
        if ($this->Shifts->save($this->request->data)) {  
            $shift_id = $this->Shifts->getLastInsertId();            
            if ($shift_services) {            
                $services = (array) json_decode($shift_services,true);            
                foreach ($services as  $service) {
                    $this->insertShiftServices($service,$shift_id);                                    
                }
            }            
             die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }
   }

   function getShiftComplete ($conditions) {

        $this->request->data = $this->Shifts->find('first', array('conditions' => $conditions));                    
        $shift = $this->request->data['Shifts'];

        if ($shift['date']) {                           
            $shift['date'] = $shift['date'];                
        }
        if ($shift['exit_hour']) {            
            list($exit_hour_date,$exit_hour_time) = explode(" ", $shift['exit_hour']);
            $shift['exit_hour_date'] = $exit_hour_date;
            $shift['exit_hour_time'] = $shift['exit_hour'];                
        }
        
        if ($shift['delivery_hour']) {
            list($delivery_hour_date,$delivery_hour_time) = explode(" ", $shift['delivery_hour']);
            $shift['delivery_hour_date'] = $delivery_hour_date;
            $shift['delivery_hour_time'] = $shift['delivery_hour'];                
        } 

        if ($shift['after_shift_start_time']) {
            list($after_shift_start_date,$after_shift_start_time) = explode(" ", $shift['after_shift_start_time']);
            $shift['after_shift_start_date'] = $after_shift_start_date;
            $shift['after_shift_start_time'] = $shift['after_shift_start_time'];                
        } 

        if ($shift['after_shift_end_time']) {
            list($after_shift_end_date,$after_shift_end_time) = explode(" ", $shift['after_shift_end_time']);
            $shift['after_shift_end_date'] = $after_shift_end_date;
            $shift['after_shift_end_time'] = $shift['after_shift_end_time'];                
        } 

        if ($shift['approved_overtime']) {
            $shift['approved_overtime'] = $after_shift_end_date. ' ' . $shift['approved_overtime'];
        } else {
            $shift['approved_overtime'] = $after_shift_end_date. ' ' . $shift['overtime'];
        } 


        $shift['shift_services'] = $this->getShiftServices($this->params['url']['rec_id']);

        $this->request->data['Shifts'] = $shift;
        
        $json_response = json_encode($this->request->data);
        echo $json_response;
        die;           
   }

   function shiftUpdateComplete () {
        $this->loadModel('Shifts');

        $id = $_GET['id'];
        $date = $_GET['date'];
        $exit_hour = $_GET['exit_hour'];
        $delivery_hour = $_GET['delivery_hour'];
        $all_calls_num = $_GET['all_calls_num'];
        $successfull_calls_num = $_GET['successfull_calls_num'];
        $unsuccessfull_calls_num = $_GET['unsuccessfull_calls_num'];
        $after_shift_start_time = $_GET['after_shift_start_time'];
        $after_shift_end_time = $_GET['after_shift_end_time'];
        $overtime = $_GET['overtime'];
        $send_shift_report = $_GET['send_shift_report'];
        $approved_overtime = $_GET['approved_overtime'];
        $approved_resttime = $_GET['approved_resttime'];
        $shift_services = $_GET['services'];
        $file_name = $_GET['file_name'];
        $description = $_GET['description'];

        $shift = $this->request->data['Shifts'];        
        $shift['id'] = $id;

        //$this->request->data['Shifts']['user_id'] = $user_id;                
        if ($date) {             
            $shift['date'] = $date;
        }

        if ($exit_hour) {            
            $shift['exit_hour'] = $exit_hour;
        }
        if ($delivery_hour) {            
            $shift['delivery_hour'] = $delivery_hour;
        }        
        if ($after_shift_start_time) {            
            $shift['after_shift_start_time'] = $after_shift_start_time;
        }
        if ($after_shift_end_time) {            
            $shift['after_shift_end_time'] = $after_shift_end_time;
        }
        if ($send_shift_report) {
            $shift['send_shift_report'] = 1;
        } else {
            $shift['send_shift_report'] = 0;
        }
        $shift['all_calls_num'] = $all_calls_num;
        $shift['successfull_calls_num'] = $successfull_calls_num;
        $shift['unsuccessfull_calls_num'] = $unsuccessfull_calls_num;
        $shift['overtime'] = $overtime;
        if ($approved_overtime) {
            $shift['approved_overtime'] = $approved_overtime;
        }

        if ($approved_resttime) {
            $shift['approved_resttime'] = $approved_resttime;    
        }
                
        $shift['file_name'] = $file_name;        
        $shift['description'] = $description;

        $this->request->data['Shifts'] = $shift;
        $this->Shifts->create();

        if ($this->Shifts->save($this->request->data)) { 
            $this->deleteShiftService($id);            
            if ($shift_services) {            
                $services = (array) json_decode($shift_services,true);                   
                foreach ($services as  $service) {
                    $this->insertShiftServices($service,$id);                                    
                }
            }              
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }


   }
  
}

?>

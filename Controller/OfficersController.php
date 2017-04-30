<?php

require_once 'MainController.php';
class OfficersController extends MainController {
	public $scaffold;
	public $helpers = array('Html', 'Form','Js');
	
	 function beforeFilter() {        
        parent::beforeFilter();
        if (isset($this->userDetails['role']) && $this->userDetails['role'] !='officer') {
        	die('You do not have access to this page.');
        }        
    }

	function index() {
	}

	function shiftReport() {
		
	}

	function missionReport() {
		
	}

	function getMissions() {        
        $curr_page = $_GET['curr_page'];
        $limit = $_GET['limit'];        
        $offset = ($curr_page - 1) * $limit;          

        $this->loadModel('Missions');     
        $missions = $this->Missions->find('all',array(
                                                      'offset' => $offset,
                                                      'limit' => $limit,
                                                      'order' => 'Missions.date DESC',
                                                ));

         $sum = $this->Missions->find('all', array(            
                                            'fields' => array('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, start_time,end_time ))) AS hours_sum',                              
                                            ),
                                    //'conditions' => $conditions
                                        ));

        //$total = $this->Missions->find('count',array('conditions' => $conditions));  
        $total = $this->Missions->find('count');  


        $json_response = json_encode(array('data'=>$missions,
                                            'total'=>$total,
                                            'curr_page'=>(int)$curr_page,
                                            'hours_sum'=> $sum[0][0]['hours_sum'],                                            
                                            ));        
        echo $json_response;
        die;
    }


    function searchMissions() {        
        $this->loadModel('Missions');  
        $curr_page = $_GET['curr_page'];
        $limit = $_GET['limit'] ;        
        $offset = ($curr_page - 1) * $limit;     
		$report_type = $_REQUEST['report_type'] ? $_REQUEST['report_type']:'';
		$user_id = $_REQUEST['user_id'];
        $department_id = $_REQUEST['department_id'];
	$mission_type = $_REQUEST['mission_type'];
		$start_date = $_REQUEST['start_date'];
		$end_date = $_REQUEST['end_date'];		
	$customer_name = trim(addslashes($_REQUEST['customer_name']));

		$conditions = array();

		if ($user_id) {
			$conditions ['Missions.user_id'] = $user_id;
		}

        if ($department_id) {
            $conditions ['User.department_id'] = $department_id;
        }

		if ($start_date) {
			$conditions['Missions.date >='] = $start_date;
		}

		if ($end_date) {
			$conditions['Missions.date <='] = $end_date;
		}

		if ($mission_type) {
			$conditions['Missions.type'] = $mission_type;

		}

	if ($customer_name) {
		$conditions['Missions.customer_name LIKE'] = "%$customer_name%";
	}

        $conditions['Missions.disabled'] = 0;
		
        $missions = $this->Missions->find('all',array('conditions' => $conditions ,
                                                      'offset' => $offset,
                                                      'limit' => $limit,
						      'order' => 'Missions.date DESC',
                                                ));

        $total = $this->Missions->find('count',array('conditions' => $conditions));        
        $sum = $this->Missions->find('all', array(            
                                            'fields' => array('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, start_time,end_time ))) AS hours_sum','SUM(days) AS days'                              
                                            ),
                                    'conditions' => $conditions
                                        ));


           
        
        $json_response = json_encode(array('data'=>$missions,
                                            'total'=>$total,
                                            'curr_page'=>(int)$curr_page,
                                            'hours_sum'=> $sum[0][0]['hours_sum'],                                           
					    'days_sum'=>$sum[0][0]['days'] 
                                            ));

        //$json_response = json_encode($missions);
        echo $json_response;
        die;
    }

    function getMissionCsv() {    	
    	$this->loadModel('Missions');  
    	
		$report_type = $_REQUEST['report_type'] ? $_REQUEST['user_id']:'';
		$user_id = $_REQUEST['user_id'];
		$start_date = $_REQUEST['start_date'];
		$end_date = $_REQUEST['end_date'];
		$mission_type = $_REQUEST['mission_type'];
		$customer_name = $_REQUEST['customer_name'];
		$str_csv = '';
		$header = array(
                'شناسه',
                'تاریخ',
                'نام مامور',
                'محل ماموریت',
                'موضوع ماموریت',
                'تاریخ شروع',
                'تاریخ پایان',
                'تعداد ساعات ماموریت',
		'تعداد روز ماموریت'
            );
        $str_csv .= implode("\t", $header) . "\n";
        
		$conditions = array();

		if ($user_id) {
			$conditions ['Missions.user_id'] = $user_id;
		}

		if ($start_date) {
			$conditions['Missions.date >='] = $start_date;
		}

		if ($end_date) {
			$conditions['Missions.date <='] = $end_date;
		}			

		if ($mission_type) {
                        $conditions['Missions.type'] = $mission_type;

                }
		$conditions['Missions.disabled'] = 0;	

	if ($customer_name) {
                $conditions['Missions.customer_name LIKE'] = "%$customer_name%";
        }
	
		
        $missions = $this->Missions->find('all',array('conditions' => $conditions ));        
        foreach ($missions as $mission) {        	
        	$tmp['id'] = $mission['Missions']['id'];
        	$tmp['jalali_date'] = $mission['Missions']['jalali_date'];
        	$tmp['name'] = $mission['User']['first_name'] .' '. $mission['User']['last_name'];
        	$tmp['customer_name'] = $mission['Missions']['customer_name'];
        	$tmp['purpose'] = $mission['Missions']['purpose'];
        	$tmp['jalali_start_date'] = $mission['Missions']['jalali_start_date'];
        	$tmp['jalali_end_date'] = $mission['Missions']['jalali_end_date'];
        	$tmp['hours'] = $mission['Missions']['hours_format'];
		$tmp['days'] = $mission['Missions']['days'];
        	$str_csv .= implode("\t", $tmp) . "\n";        	
        }
        
        $this->get_csv_report('mission',$start_date,$end_date,$str_csv);
        die;        
    }

    function getShifts() {      
        $curr_page = $_GET['curr_page'];
        $limit = $_GET['limit'];        
        $offset = ($curr_page - 1) * $limit;  

        $this->loadModel('Shifts');     

        $total = $this->Shifts->find('count');
        $sum = $this->Shifts->find('all', array(            
            'fields' => array('sum(Shifts.overtime) as overtime_sum','sum(Shifts.approved_overtime) AS approved_overtime_sum'
                    )
                )
            );

        $shifts = $this->Shifts->find('all',array(
                                                  //'conditions' => 'User.department_id=2',
                                                  'order' => 'Shifts.id DESC',
                                                  'offset' => $offset,
                                                  'limit' => $limit));
        
        $json_response = json_encode(array('data'=>$shifts,'total'=>$total,'curr_page'=>(int)$curr_page,
                                            'overtime_sum'=> $sum[0][0]['overtime_sum'],
                                            'approved_overtime_sum'=> $sum[0][0]['approved_overtime_sum'],
                                            ));
        echo $json_response;
        die;
    }

    function searchShifts() {        
        $this->loadModel('Shifts');     

        $curr_page = $_GET['curr_page'];
        $limit = $_GET['limit'] ;        
        $offset = ($curr_page - 1) * $limit;  
        
		$user_id = $_REQUEST['user_id'];
        $department_id = $_REQUEST['department_id'];
		$start_date = $_REQUEST['start_date'];
		$end_date = $_REQUEST['end_date'];
		$conditions = array();

		if ($user_id) {
			$conditions ['Shifts.user_id'] = $user_id;
		}

        if ($department_id) {
            $conditions ['User.department_id'] = $department_id;
        }

		if ($start_date) {
			$conditions['Shifts.date >='] = $start_date;
		}

		if ($end_date) {
			$conditions['Shifts.date <='] = $end_date;
		}		       

	$conditions['Shifts.disabled'] = 0; 
		
        $total = $this->Shifts->find('count',array('conditions' => $conditions));
        $shifts = $this->Shifts->find('all',array('conditions' => $conditions ,
                                                    'offset' => $offset,
                                                    'limit' => $limit,
                                                    'order' => 'Shifts.date DESC'
            ));



        $sum = $this->Shifts->find('all', array(            
            'fields' => array('sum(Shifts.approved_overtime) AS approved_overtime_sum',
                              'SEC_TO_TIME(SUM(TIME_TO_SEC(overtime))) AS overtime_sum',
                              'SEC_TO_TIME(SUM(TIME_TO_SEC(approved_overtime))) AS approved_overtime_sum'),
            'conditions' => $conditions
                ) );
           
        
        $json_response = json_encode(array('data'=>$shifts,'total'=>$total,'curr_page'=>(int)$curr_page,
                                            'overtime_sum'=> $sum[0][0]['overtime_sum'],
                                            'approved_overtime_sum'=> $sum[0][0]['approved_overtime_sum'],
                                            ));

        echo $json_response;
        die;
    }

    function getShiftsCsv() {    	
    	$this->loadModel('Shifts');  
    	
		$report_type = $_REQUEST['report_type'] ? $_REQUEST['user_id']:'';
		$user_id = $_REQUEST['user_id'];
        $department_id = $_REQUEST['department_id'];
		$start_date = $_REQUEST['start_date'];
		$end_date = $_REQUEST['end_date'];
		$str_csv = '';
		$header = array(
                'شناسه',
                'تاریخ',
                'نام پرسنل شیفت',
                
                'نام مشتری',
                'رابط فنی (مشتری)',
                'شرح مشکل',
                'شماره تیکت',
                'توضیحات',
                
                'ساعت خروج از شرکت',
                'ساعت تحویل شیفت',
                'تعداد تماس‌ها',
                'تعداد تماس‌های موفق',
                'تعداد تماس‌های ناموفق',
                'اضافه کاری',                
                'اضافه کاری تایید شده',
                'تاخیر تایید شده'
            );
        $str_csv .= implode("\t", $header) . "\n";
        
		$conditions = array();

		if ($user_id) {
			$conditions ['Shifts.user_id'] = $user_id;
		}

        if ($department_id) {
            $conditions ['User.department_id'] = $department_id;
        }

	if ($start_date) {
		$conditions['Shifts.date >='] = $start_date;
	}

	if ($end_date) {
		$conditions['Shifts.date <='] = $end_date;
	}
	$conditions['Shifts.disabled'] = 0;			
		
        $shifts = $this->Shifts->find('all',array('conditions' => $conditions ));
        foreach ($shifts as $shift) {        	
        	$tmp['id'] = $shift['Shifts']['id'];
        	$tmp['jalali_date'] = $shift['Shifts']['jalali_date'];
        	$tmp['name'] = $shift['User']['first_name'] .' '. $shift['User']['last_name'];
        	$tmp['jalali_exit_hour'] = $shift['Shifts']['jalali_exit_hour'];
        	$tmp['jalali_delivery_hour'] = $shift['Shifts']['jalali_delivery_hour'];        	
        	$tmp['all_calls_num'] = $shift['Shifts']['all_calls_num'];
        	$tmp['successfull_calls_num'] = $shift['Shifts']['successfull_calls_num'];
        	$tmp['unsuccessfull_calls_num'] = $shift['Shifts']['unsuccessfull_calls_num'];
        	$tmp['overtime'] = $shift['Shifts']['overtime'];
        	$tmp['approved_overtime'] = $shift['Shifts']['approved_overtime'];
        	$tmp['approved_resttime'] = $shift['Shifts']['approved_resttime'];
        	$str_csv .= implode("\t", $tmp) . "\n";        	
        }
        
        $this->get_csv_report('shift',$start_date,$end_date,$str_csv);
        die;        
    }



	

}



?>

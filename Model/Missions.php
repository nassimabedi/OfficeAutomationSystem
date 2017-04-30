<?php
//require_once '../Controller/include/pdate.php';
class Missions extends AppModel {
	var $useTable = "missions";
	
	public $virtualFields = array('jalali_start_date' => 'start_time',
									'jalali_end_date' =>'end_time',
									'jalali_date'=>'date',
									'hours_format'=>'hours',
									);
    public $belongsTo = array(
	    'User' => array(
	        'className'    => 'User',
	        'foreignKey'   => 'user_id',
	    )
	);
	public function __construct($id = false, $table = null, $ds = null) {
	    parent::__construct($id, $table, $ds);
	}

	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $fields) {
	    	foreach ($fields as $field) {
	    			if ($field['jalali_start_date']) {	    				
	    				//$results[$key]['Missions']['jalali_start_date'] = getJalaliTime($field['jalali_start_date']) ;	    				
	    				$results[$key]['Missions']['jalali_start_date'] = getJalaliDateTime($field['jalali_start_date']) ;	
	    				//getJalaliDateTime
	    			}
	    			if ($field['jalali_end_date']) {	    				
	    				//$results[$key]['Missions']['jalali_end_date'] = getJalaliTime($field['jalali_end_date']) ;	    				
	    				$results[$key]['Missions']['jalali_end_date'] = getJalaliDateTime($field['jalali_end_date']) ;	    				
	    			}
	    			if ($field['jalali_date']) {	    				
	    				$results[$key]['Missions']['jalali_date'] = getJalali($field['jalali_date']) ;	    				
	    			}	
	    			//if ($field['hours_format']) {	    				
	    			if ($field['hours']) {	 
	    				//$results[$key]['Missions']['hours_format'] = date('h:i:s',$field['hours_format']) ;	    				
	    				$results[$key]['Missions']['hours_format'] = show_hours($field['hours']);
	    			}	    			
	    	}
		}
    	return $results;
	}


	
}
?>

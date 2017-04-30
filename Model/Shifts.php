<?php
class Shifts extends AppModel {
	var $useTable = "shifts";
	
	public $virtualFields = array(	'jalali_date'=>'date',
									'jalali_exit_hour' => 'exit_hour',
									'jalali_delivery_hour' =>'delivery_hour',
									'jalali_after_shift_start_time'=>'after_shift_start_time',
									'jalali_after_shift_end_time'=>'after_shift_end_time');

    public $belongsTo = array(
	    'User' => array(
	        'className'    => 'User',
	        'foreignKey'   => 'user_id',
	    )
	);

	//ebrahim
	public $hasMany = array(
		'shift_services' => array(
			'className' => 'ShiftServices',
	        'foreignKey'   => 'shift_id',
		)
	);
	//ebrahim-end

	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $fields) {
	    	foreach ($fields as $field) {

	    			if ($field['jalali_date']) {	    				
	    				$results[$key]['Shifts']['jalali_date'] = getJalali($field['jalali_date']) ;	    				
	    			}
	    			if ($field['jalali_exit_hour']) {	    				
	    				$results[$key]['Shifts']['jalali_exit_hour'] = getJalaliDate($field['jalali_exit_hour']) ;	
	    			}
	    			if ($field['jalali_delivery_hour']) {	    				
	    				$results[$key]['Shifts']['jalali_delivery_hour'] = getJalaliDate($field['jalali_delivery_hour']) ;	    				
	    			}

	    			if ($field['overtime']) {
	    				//$overtime = time_diff_by_hour($field['overtime']) ;
						//$results[$key]['Shifts']['overtime'] = $overtime['hours'] .':'.$overtime['minutes'].':'.$overtime['seconds'] ;	    					    				
	    			}


	    			if ($field['jalali_after_shift_start_time']) {	    				
	    				$results[$key]['Missions']['jalali_after_shift_start_time'] = getJalaliTime($field['jalali_after_shift_start_time']) ;
	    			}	
	    			if ($field['jalali_after_shift_end_time']) {	    				
	    				$results[$key]['Missions']['jalali_after_shift_end_time'] = getJalaliTime($field['jalali_after_shift_end_time']) ;
	    			}

	    	}
		}
    	return $results;
	}
	
}
?>

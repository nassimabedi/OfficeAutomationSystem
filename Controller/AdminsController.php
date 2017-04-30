<?php

require_once 'MainController.php';
class AdminsController extends MainController {
	public $scaffold;
	public $helpers = array('Html', 'Form','Js');


	function beforeFilter() {        
        parent::beforeFilter();
        if (isset($this->userDetails['role']) && $this->userDetails['role'] !='admin') {
        	die('You do not have access to this page.');
        }        
    }

	function index() {
	}
	

	function departmentList() {

	}


	function departmentAdd() {

	}

	function departmentInsert() {		
        $this->loadModel('Departments');           

        $department = $_GET['department'];
        $this->request->data['Departments']['name'] = $department;        
        $this->Departments->create();

        if ($this->Departments->save($this->request->data)) {                
             die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }

	}

	function departmentEdit() {

	}

	function getDepartment() {
		$this->loadModel('Departments');     
		$this->Departments->id = $this->params['url']['rec_id'];        
        $departments = $this->Departments->find('all', array('fields' => array('id','name'),
                                                        'conditions' => array('Departments.id' => $this->Departments->id)
                                                    ));
        
        $json_response = json_encode($departments[0]);
        echo $json_response;
        die;
	}

	function departmentUpdate() {
        $this->loadModel('Departments');           
        $department = $_REQUEST['department']; 
        $id = $_REQUEST['id'];                     
        $this->request->data['Departments']['id'] = $id;
        $this->request->data['Departments']['name'] = $department;                    

        if ($this->Departments->save($this->request->data)) {            
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }
    }


	function userList() {

	}


	function getUsers() {
		$this->loadModel('User');
		$users_list = $this->User->find('all',array(
                                                'conditions' => array('User.disabled'=> 0)
                                            ));
        $json_response = json_encode($users_list);
        echo $json_response;
        die;
	}

	function userAdd () {
		
	}


	function userInsert () {
		$this->loadModel('User');           
        $first_name = $_REQUEST['first_name']; 
        $last_name = $_REQUEST['last_name'];
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $department_id = $_REQUEST['department'];
        $role_id = $_REQUEST['role'];               

        $this->request->data['User']['first_name'] = $first_name;
        $this->request->data['User']['last_name'] = $last_name;                    
        $this->request->data['User']['username'] = $username;                    
        $this->request->data['User']['password'] = $password;                    
        $this->request->data['User']['department_id'] = $department_id;
        $this->request->data['User']['role'] = $role_id;       

        if ($this->User->save($this->request->data)) {            
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }
	}

	function getUser() {
		$this->loadModel('User');     
		$this->User->id = $this->params['url']['rec_id'];        
        $users = $this->User->find('all', array(
                                                        'conditions' => array('User.id' => $this->User->id)
                                                    ));
        
        $json_response = json_encode($users[0]);
        echo $json_response;
        die;

	}

	function userEdit () {
		
	}

	function userUpdate() {
        $this->loadModel('User');           
        $department = $_REQUEST['department']; 
        $id = $_REQUEST['id'];   

        $first_name = $_REQUEST['first_name']; 
        $last_name = $_REQUEST['last_name'];
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $department_id = $_REQUEST['department'];
        $role_id = $_REQUEST['role'];               
        $this->request->data['User']['id'] = $id;     
        $this->request->data['User']['first_name'] = $first_name;
        $this->request->data['User']['last_name'] = $last_name;                    
        $this->request->data['User']['username'] = $username;                    
        $this->request->data['User']['password'] = $password;                    
        $this->request->data['User']['department_id'] = $department_id;
        $this->request->data['User']['role'] = $role_id;   

        if ($this->User->save($this->request->data)) {            
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }
    }

    function angularPrompt() {

    }

    function settingsList() {

    }

    function getSettings() {
        $this->loadModel('Settings');
        $settings = $this->Settings->find('all');
        
        $json_response = json_encode($settings);
        echo $json_response;
        die;
    }

    function settingEdit() {        
    }

    function getSetting() {
        $this->loadModel('Settings');     
        $this->Settings->id = $this->params['url']['rec_id'];        
        $setting = $this->Settings->find('all', array('fields' => array('id','leave_time'),
                                                        'conditions' => array('Settings.id' => $this->Settings->id)
                                                    ));    
        
        $setting[0]['Settings']['leave_time'] = date('Y-m-d') .' '.$setting[0]['Settings']['leave_time'];
        $json_response = json_encode($setting[0]);
        echo $json_response;
        die;
    }

    public function settingUpdate() {
        $this->loadModel('Settings');           
        $leave_time = $_REQUEST['leave_time']; 
        $id = $_REQUEST['id'];                     
        $this->request->data['Settings']['id'] = $id;
        $this->request->data['Settings']['leave_time'] = $leave_time;                    

        if ($this->Settings->save($this->request->data)) {            
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }
    }

    function deleteUser() {
        $this->loadModel('User');                  
        $id = $_REQUEST['id'];   

        $this->request->data['User']['id'] = $id;     
        $this->request->data['User']['disabled'] = 1;        
        if ($this->User->save($this->request->data)) {            
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }
        die();
    }

    function deleteDepartment() {

        $this->loadModel('Departments');           
        
        $id = $_REQUEST['id'];                     
        $this->request->data['Departments']['id'] = $id;
        $this->request->data['Departments']['disabled'] = 1;                    

        if ($this->Departments->save($this->request->data)) {            
            die('رکود با موفقیت ثبت شد');
        } else {
            die('خطایی در ثبت رکورد وجود دارد');
        }
                        
    }

}


?>

<?php

// app/Controller/UsersController.php
class UsersController extends AppController {

    var $components = array ('RequestHandler');
    public function beforeFilter() {
        parent::beforeFilter();
       // $this->Auth->allow('add', 'logout', 'loggedout');
    }


    public function login() {
        if ($this->Auth->login()) {		    
            $ath = $this->Auth->user();            
            if ($ath['role'] == 'admin') {
                $this->redirect(array('controller' => 'Admins', 'action' => 'index'));
            } else if ($ath['role'] == 'staff') {
                $this->redirect(array('controller' => 'Staffs', 'action' => 'index'));
            } else if ($ath['role'] == 'manager') {
                $this->redirect(array('controller' => 'Managers', 'action' => 'index'));
            } else if ($ath['role'] == 'officer') {
                $this->redirect(array('controller' => 'Officers', 'action' => 'index'));
            }
            $this->redirect($this->Auth->loginRedirect);
        } else {
            //$this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    public function loggedout(){
        //do nothing
    }

    public function index() {
        if ($this->userDetails['role'] !='admin' ) {
            die('You do not have to access this page!');
        }
        $this->User->recursive = 0;            
        $this->set('users', $this->paginate());
    }


    function getUserList() {
            $users_list = $this->User->find('all');
            $json_response = json_encode($users_list);
            echo $json_response;
            die;
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }


    public function add() {
        if ($this->userDetails['role'] !='admin' ) {
            die('You do not have to access this page!');
        }
        $this->loadModel('Departments');
        $departments_list = $this->Departments->find('list');
        $this->set('departments',$departments_list);
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        if ($this->userDetails['role'] !='admin' ) {
            die('You do not have to access this page!');
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            
            $this->loadModel('Departments');
            $departments_list = $this->Departments->find('list');
            $this->set('departments',$departments_list);    
            $this->set('userRoles',$this->getUserRoles());
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        $this->User->saveField('disabled', '1');
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function getUserRoles() {
        $role = array('manager'=> 'manager',
                        'staff'=>'staff',
                        'admin'=>'admin',
                        'officer'=>'officer'
                        );
        return $role;

    }

    public function changePassword() {                
        if ($this->request->is('post') || $this->request->is('put')) {            
            $this->User->id = $this->userDetails['id'];            
            $data = array('id' => $this->userDetails['id'], 'password' => $this->request->data['User']['password'] );            
            if ($this->User->save($data)) {            
                $this->Session->setFlash(__('The password has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
    }
    

    public function updatePassword() {   

        $this->User->id = $this->userDetails['id'];    
        $password = trim($_GET['password']);                
        $data = array('id' => $this->userDetails['id'], 'password' => $password );            
        if ($this->User->save($data)) {                             
            die('رکود با موفقیت ثبت شد');           
        } else {   
            die('خطایی در ثبت رکورد وجود دارد');         
        }
        die;
    }

   



}

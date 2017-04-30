<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

     /*public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'pages', 'action' => 'display', 'loggedin'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'loggedout')
        )
    );*/


    public $components = array(
        'Session',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password'
                    )
                )
            ),            
            'loginAction' => array('controller' => 'users', 'action' => 'login'),
            'loginRedirect' => array('controller' => 'pages', 'action' => 'display','loggedin'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'loggedout'),                        
        )
    );






    function beforeFilter() {        
        parent::beforeFilter();
        $ath = $this->Auth->user();
        $this->userDetails = $ath;
        $this->set('name',$this->userDetails['first_name']);
        $this->set('profile_pic',$this->userDetails['profile_pic']);
    }


}

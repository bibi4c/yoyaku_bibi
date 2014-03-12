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
	//var $needAuth = false;
	public $components = array('Auth', 'Session', 'RequestHandler');
	public function beforeFilter() {
		
		$this->disableCache();		
 			$this->Auth->authenticate = array(
					'Form' => array(
							'userModel' => 'User',
							'fields' => array('username' => 'mail_address', 'password' => 'password'),
							//'scope' => array('department_id'=>'0')
							)
			);
			
			$this->Auth->loginAction = array('controller' => 'login', 'action' => 'login');
			$this->Auth->loginRedirect = array('controller' => 'login', 'action' => 'login');
		
		$this->Auth->loginError = 'Failed to login';
		$this->Auth->authError = ' ';
			
		$this->layout = 'login';
	}
	/* public function appError(){
		$this->redirect(array('controller'=>'login','action'=>'logout'));
	} */
}



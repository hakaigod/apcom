<?php
/**
 * Created by PhpStorm.
 * User: 15110006
 * Date: 2017/07/06
 * Time: 14:22
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;

class LoginController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		
		
	}
	
	
	public function index()
	{
		
		$session = $this->request->session();
		$this->viewBuilder()->layout('login');
		
		if(!empty($session->read('username') ) && !empty($session->read('role')) && !empty($session->read('userID'))){
			if($session->read('role')==="student"){
				$this->redirect([ 'controller' => 'student','action' => 'summary','id' => $session->read('userID')]);
			}else if($session->read('role')==="manager"){
				$this->redirect([ 'controller' => 'Manager','action' => 'index']);
			}
		}
		
		/*      $this->set('users', $this->Users->find('all'));*/
		if(!empty($_POST["admin"]) && $_POST["admin"] =="Manager"){
			$this->loadComponent('Auth', [
				'loginAction' => [
					'controller' => 'Login',
					'action' => 'index'
				],
				'authenticate' => [
					'Form' => [
						'userModel' => 'mf_adm',
						'fields' => [
							'username' => 'admnum',
							'password' => 'admpass'
						],
						'finder' => 'Auth'
					]
				],
				
				'loginRedirect' => [
					'controller' => 'Manager',
					'action' => 'index'
				],
				'logoutRedirect' => [
					'controller' => 'Pages',
					'action' => 'display',
					'home'
				]
			]);
		}else{
			$this->loadComponent('Auth', [
				'loginAction' => [
					'controller' => 'Login',
					'action' => 'index'
				],
				'authenticate' => [
					'Form' => [
						'userModel' => 'mf_stu',
						'fields' => [
							'username' => 'regnum',
							'password' => 'stupass'
						],
						'finder' => 'Auth'
					]
				],
				
				'loginRedirect' => [
					'controller' => 'student',
					'action' => 'summary',
					'id' => $this->request->getData("regnum")
				],
				'logoutRedirect' => [
					'controller' => 'Pages',
					'action' => 'display',
					'home'
				]
			]);
			
		}
		if(!empty($_POST)) {
			if ($this->request->is('post')) {
				$user = $this->Auth->identify();
				if ($user) {
					$this->Auth->setUser($user);
					if (!empty($_POST["admin"]) && $_POST["admin"] == "Manager") {
						$session->write([
							                'username' => $user['admname'],
							                'role' => 'manager',
							                'userID' => $user['admnum']
						                ]);
					} else {
						$session->write([
							                'username' => $user['stuname'],
							                'role' => 'student',
							                'userID' => $user['regnum']
						                ]);
					}
					return $this->redirect($this->Auth->redirectUrl());
				} else {
					$errorMessage = '番号かパスワードが間違っています。';
					$this->set('errorMessage', $errorMessage);
				}
				$this->Flash->error(__('Invalid username or password, try again'));
			} else {
				$errorMessage = '番号かパスワードが間違っています。';
				$this->set('errorMessage', $errorMessage);
			}
		}
	}
	
	
	public function login()
	{
	
	}
	
	public function logout()
	{
		$this->request->session()->destroy(); // セッションの破棄
		return $this->redirect($this->Auth->logout());
	}
	
}
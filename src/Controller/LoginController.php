<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class LoginController extends AppController
{
	public function initialize(){
		parent::initialize();
		$this->viewBuilder()->layout('login');
	}

	public function index()
	{
	}
}

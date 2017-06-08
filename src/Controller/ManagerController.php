<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class ManagerController extends AppController
{
	public function initialize(){
		parent::initialize();
		// $this->viewBuilder()->layout('default');
		$this->set('headerlink', $this->request->webroot . '/Manager');
	}

	public function index()
	{
	}
	public function strmanager()
	{
	}
	public function addstr()
	{
		$this->viewBuilder()->layout('addmod');
	}
	public function modstr()
	{
		$this->viewBuilder()->layout('addmod');
	}
	public function searchstr()
	{
	}

}

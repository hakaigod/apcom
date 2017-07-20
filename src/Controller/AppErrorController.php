<?php
namespace App\Error;

use Cake\Controller\ErrorController;
use Cake\Event\Event;

class AppErrorController extends ErrorController {
	public function beforeRender(Event $event)
	{
		//Templateファイルのあるパスを指定(src/Template/Error/)
		$this->viewBuilder()->templatePath('Error');
	}
}

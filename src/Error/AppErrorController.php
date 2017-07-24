<?php
namespace App\Error;

use Cake\Controller\ErrorController;
use Cake\Event\Event;

class AppErrorController extends ErrorController {

	public function initialize(){
		$this->set("logoLink", ["controller" => "login", "action" => "index"]);
		$session = $this->request->session();
		// セッション情報取得
		if (!empty($session->read('username'))) {
			if ($session->read('role') == 'student') {
				$this->redirect(['controller' => 'student', 'action' => 'summary','id' => $session->read('userID')]);
			} else {
				$this->set("userID", $session->read('userID'));
				$this->set("username", $session->read('username'));
			}
		} else {
			$this->redirect(['controller' => 'Login', 'action' => 'index']);
		}
	}

    public function beforeRender(Event $event)
    {
		$this->viewBuilder()->layout('error');

		//Templateファイルのあるパスを指定(src/Template/Error/)
		$this->viewBuilder()->templatePath('Error');
    }
}

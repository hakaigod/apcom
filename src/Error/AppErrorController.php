<?php
namespace App\Error;

use Cake\Controller\ErrorController;
use Cake\Event\Event;

class AppErrorController extends ErrorController {
    public function beforeRender(Event $event)
    {
      //ＰＣ用とモバイル用のLayoutを切り替える
      //「src/Template/Layout/」の下にあるLayoutファイルを参照している
      if($this->request->is('mobile')){
        $this->viewBuilder()->layout('mobile');
      }else{
        $this->viewBuilder()->layout('normal');
      }

      //Templateファイルのあるパスを指定(src/Template/Error/)
      $this->viewBuilder()->templatePath('Error');
    }
}

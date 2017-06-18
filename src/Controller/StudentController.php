<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Collection\Collection;

class StudentController extends AppController
{
    public function initialize(){
        parent::initialize();

    }

    public function index(){
    	$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
    }
    public function summary(){
    	//URLから学籍番号取得
	    $regnum = $this->request->getParam('id');
	    //左上のロゴのURL設定
	    $this->set("headerlink", $this->request->getAttribute('webroot') . "Student/" . $regnum);
		$session =     $this->request->session();
	    $session->write('StudentID', $regnum);
	    $this->set(compact('session'));
	    //回答モデル読み込み
	    $this->loadModel('TfAns');
	    //回答取得
	    $answers = $this->TfAns->find()
		    ->where(['TfAns.regnum = ' => $regnum])
		    ->toArray();
	    $answers = new Collection($answers);
	    //自然な順にソート
	    $answers = $answers->sortBy('qesnum',SORT_NATURAL);
	    $this->set(compact('answers'));
	    
	    //生徒モデル読み込み
	    $this->loadModel('MfStu');
	    //生徒名取得
	    $name = $this->MfStu->find()
		    ->where(['MfStu.regnum = ' => $regnum])
		    ->first();
	    $this->set(compact('name'));
    }
    public function input(){
	    //回答モデル読み込み
	    $this->loadModel('TfAns');
	    //左上のロゴのURL設定
	    $this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
	    
	    //模擬試験テーブルの主キー
	    $imiNum = $this->request->getParam('imiNum');
	    //1-8の番号
	    $getLinkNum = $this->request->getParam('linkNum');
	    if (isset($imiNum) && isset($getLinkNum)) {
		    $this->loadModel('TfImi');
		    $imitation = $this->TfImi->find()
			    ->contain(['MfExa'])
			    ->where(['TfImi.imicode = ' => $imiNum] )
			    ->first();
		    
		    
		    //模擬試験コードから試験実施年度と季節を取得しビューにセット
		    $this->set(compact('imitation'));
		    $this->set(compact('getLinkNum'));
		    //POSTメソッドであるときは回答を入力している
		    if ($this->request->is('post')) {
//
//			    $qnum = $this->request->getData('linkNum');
//			    $session = $this->request->session();
//			    $session->write('answers.' . ,2);
		    }else{
				
		    }
	    }else{
	    
	    }
	  }
}

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
	    
	    $season = $this->request->getParam('season');
	    if (isset($season)) {
		    $this->set(compact('season'));
		
		    $qnum = $this->request->getParam('qnum') ? : 1;
		    $this->set(compact('qnum'));
	    }
	    if ($this->request->is('post')) {
		   
	    }else{
	    
	    }
    }
}

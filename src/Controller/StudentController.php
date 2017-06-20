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

//    public function index(){
//    	$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
//    }
	//ユーザマイページに表示される画面
	public function summary(){
		//URLから学籍番号取得
		$regnum = $this->request->getParam('id');
		//左上のロゴのURL設定
		$this->set("headerlink", $this->request->getAttribute('webroot') . "Student/" . $regnum);
		$session = $this->request->session();
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
	//模擬試験結果入力画面
	public function input(){
		
		$session = $this->request->session();
		
		//回答モデル読み込み
		$this->loadModel('TfAns');
		//左上のロゴのURL設定
		$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
		
		//模擬試験テーブルの主キー
		$imiNum = $this->request->getParam('imiNum');
		//1-8の番号
		$curNum = $this->request->getParam('linkNum') ?: 1;
		if (isset($imiNum) && isset($curNum)) {
			
			//現在のページ番号をセット
			$this->set(compact('curNum'));
			//模擬試験コードから試験実施年度と季節を取得
			$this->loadModel('TfImi');
			$imitation = $this->TfImi->find()
				->contain(['MfExa'])
				->where(['TfImi.imicode' => $imiNum] )
				->first();
			//和暦セット
			$year = $imitation['mf_exa']->jap_year;
			$this->set(compact('year'));
			//デバッグ用
			$this->set(compact('imitation'));
			//季節セット
			$season = $imitation['mf_exa']['exaname'];
			$this->set(compact('season'));
			
			//問題文セット
			$this->loadModel('MfQes');
			$questions = $this->MfQes
				//問題文のみ取得、試験回と取得する問題数とOFFSETを指定
				->getTexts(['MfQes.exanum' => $imitation['mf_exa']->exanum],10,$curNum)
				->toArray();
			$this->set(compact('questions'));
			
			//過去入力した選択肢、自信度がセッションに存在する場合
			//既定値としてビューにセットする
			$iniQueAfNum = ( $curNum - 1 ) * 10 + 1;
			$inputtedLog = [];
			for ($qNum = $iniQueAfNum ; $qNum < $iniQueAfNum + 10; $qNum++ ) {
				$inputtedLog['answers'][$qNum] = $session->read('answers.' . $qNum) ?: 0;
				$inputtedLog['confidences'][$qNum] = $session->read('confidences.' . $qNum) ?: 2;
			}
			$this->set(compact('inputtedLog'));
			
			//回答入力時
			if ($this->request->is('post')) {
				//遷移元ページのリンク番号
				$befNum = $this->request->getData("curNum");
				//遷移元ページの一番最初の問題番号
				$iniQueBefNum = ( $befNum - 1 ) * 10 + 1;
				for ($qNum = $iniQueBefNum ; $qNum < $iniQueBefNum + 10; $qNum++ ){
					//POSTされた回答と自信度を取得
					$answer = $this->request->getData("answer_{$qNum}");
					$confidence = $this->request->getData("confidence_{$qNum}");
					
					//解答と自信度をセッションに書き込む
					$session->write('answers.' . $qNum, $answer);
					$session->write('confidences.' . $qNum, $confidence);

//				    array_push($answers, $answer);
//				    array_push($confidences, $confidence);
				}
//			    $this->set(compact('answers'));
//			    $this->set(compact('confidences'));
//			    $qnum = $this->request->getData('linkNum');
			}else{
				//GETメソッドの場合
				
			}
		}
	}
}

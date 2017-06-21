<?php
namespace App\Controller;

use App\Model\Table\MfQesTable;
use App\Model\Table\MfStuTable;
use App\Model\Table\TfAnsTable;
use App\Model\Table\TfImiTable;

/**
 * @property TfAnsTable TfAns
 * @property MfStuTable MfStu
 * @property TfImiTable TfImi
 * @property MfQesTable MfQes
 */
class StudentController extends AppController
{
	public function initialize(){
		parent::initialize();
		
		//左上のロゴのURL設定
		$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
	}

//    public function index(){
//    	$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
//    }
	//ユーザマイページに表示される画面
	public function summary(){
		
		//回答モデル読み込み
		$this->loadModel('TfAns');
		//生徒モデル読み込み
		$this->loadModel('MfStu');
		
		$session = $this->request->session();
		
		//TODO:この行はセッションが実装されたら消す
		$session->write('StudentID', '15110007');

		$regnum = $session->read('studentID');
		//回答取得
		$answers = $this->TfAns->find()
			->where(['TfAns.regnum = ' => $regnum])
			->toArray();
		$this->set(compact('answers'));
		
		//生徒名取得
		$name = $this->MfStu->find()
			->where(['MfStu.regnum = ' => $regnum])
			->first();
		$this->set(compact('name'));
	}
	//模擬試験結果入力画面
	public function input(){
		
		$session = $this->request->session();
		
		//回答テーブル
		$this->loadModel('TfAns');
		//模擬試験テーブル
		$this->loadModel('TfImi');
		//問題テーブル
		$this->loadModel('MfQes');
		
		//模擬試験テーブルの主キー
		$imicode = $this->request->getParam('imicode');
		//模擬試験コードから試験実施年度と季節を取得
		$imitation = $this->TfImi->getOneAndMfExam($imicode);
		//和暦セット
		$year = $imitation['mf_exa']->jap_year;
		$this->set(compact('year'));
		//デバッグ用
		$this->set(compact('imitation'));
		//季節セット
		$season = $imitation['mf_exa']['exaname'];
		$this->set(compact('season'));
		
		//今から送信するページ番号 範囲は1-8
		$curNum = $this->request->getParam('linkNum');
		if (isset($curNum)) {
			//現在のページ番号をセット
			$this->set(compact('curNum'));
			//問題文セット
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
				}
			}
		}
	}
	public function confirm() {
	
	}
}

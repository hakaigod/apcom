<?php
namespace App\Controller;

use App\Model\Table\MfQesTable;
use App\Model\Table\MfStuTable;
use App\Model\Table\TfAnsTable;
use App\Model\Table\TfImiTable;
use App\Model\Table\TfSumTable;
use Cake\Http\ServerRequest;

/**
 * @property TfAnsTable TfAns
 * @property MfStuTable MfStu
 * @property TfImiTable TfImi
 * @property MfQesTable MfQes
 * @property TfSumTable TfSum
 */
class StudentController extends AppController
{
	public function initialize(){
		parent::initialize();
		
		//左上のロゴのURL設定
		$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
		
		//回答テーブル
		$this->loadModel('TfAns');
		//模擬試験テーブル
		$this->loadModel('TfImi');
		//問題テーブル
		$this->loadModel('MfQes');

	}

//    public function index(){
//    	$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
//    }
	//ユーザマイページに表示される画面
	public function summary(){
		
		//回答モデル読み込み
		$this->loadModel('TfSum');
		//生徒モデル読み込み
		$this->loadModel('MfStu');
		
		$session = $this->request->session();
		
		//TODO:この行はセッションが実装されたら消す
		$session->write('StudentID', '13110025');
		
		$regnum = $session->read('StudentID');
		
		//生徒名取得
		$stuName = $this->MfStu->find()
			->where(['MfStu.regnum = ' => $regnum])
			->first()
			->get('name');
		$this->set(compact('stuName'));
		
		//回答取得
		$sums = $this->TfSum->find()
			->where(['TfSum.regnum' => $regnum])
			->toArray();
		$this->set(compact('sums'));
	}
	//模擬試験結果入力画面
	public function input(){
		
		$session = $this->request->session();
		
		//模擬試験テーブルの主キー
		$imicode = $this->request->getParam('imicode');
		//模擬試験コードから試験実施年度と季節を取得
		$imitation = $this->TfImi->getOneAndMfExam($imicode);
		
		$this->setYearAndSeason($imitation);
		//リクエストされたページ番号 範囲は1-8
		$curNum = $this->request->getParam('linkNum');
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
			$inputtedLog['answers'][$qNum] =
				$session->read($this->genSsnTag(['answers',$imicode,$qNum]));
			$inputtedLog['confidences'][$qNum] =
				$session->read($this->genSsnTag(['confidences',$imicode,$qNum]));
		}
		$this->set(compact('inputtedLog'));
		
		//回答入力時
		if ($this->request->is('post')) {
			$this->writeAnsToSsn($this->request);
		}
	}
	private function setYearAndSeason(\Cake\Datasource\EntityInterface $imitation){
		//和暦セット
		$this->set('year',$imitation['mf_exa']->jap_year);
		//季節セット
		$this->set('season',$imitation['mf_exa']['exaname']);
		
	}
	private function writeAnsToSsn(ServerRequest $request){
		$imicode = $request->getParam('imicode');
		//遷移元ページのリンク番号
		$befNum = $request->getData("curNum");
		if (!isset($imicode) or !isset($befNum)) return;
		$session = $request->session();
		//すでに書いたページ番号にtrueを設定
		$session->write($this->genSsnTag(['inputtedPages',$befNum]),true);
		//遷移元ページの一番最初の問題番号
		$iniQueBefNum = ( $befNum - 1 ) * 10 + 1;
		for ($qNum = $iniQueBefNum ; $qNum < $iniQueBefNum + 10; $qNum++ ){
			//POSTされた回答と自信度を取得
			$answer = $request->getData("answer_{$qNum}");
			$confidence = $this->request->getData("confidence_{$qNum}");
			//解答と自信度をセッションに書き込む
			$session->write($this->genSsnTag(['answers',$imicode,$qNum]), $answer);
			$session->write($this->genSsnTag(['confidences',$imicode, $qNum]), $confidence);
		}
	}
	
	public function result() {
		//回答入力時
		//TODO:セッションかなんかでPOST元が解答画面かチェック
		if ($this->request->is('post')) {
			$this->writeAnsToSsn($this->request);
		}
	}
	private function genSsnTag( array $children): String{
		return implode(".", $children);
	}
}
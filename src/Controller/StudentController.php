<?php
namespace App\Controller;

use App\Model\Table\MfQesTable;
use App\Model\Table\MfStuTable;
use App\Model\Table\TfAnsTable;
use App\Model\Table\TfImiTable;
use App\Model\Table\TfSumTable;
use Cake\Http\ServerRequest;
use Cake\Datasource\EntityInterface;
use Cake\Network\Session;

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
			$inputtedLog['answers'][$qNum] = $this->readSession([ 'answers', $imicode, $qNum ]);
			$inputtedLog['confidences'][$qNum] = $this->readSession(['confidences',$imicode,$qNum]);
		}
		$this->set(compact('inputtedLog'));
		
		//回答入力時(=POST)
		if ($this->request->is('post')) {
			//セッションに解答を書き込む
			$this->writeAnsToSsn($this->request);
		}
		//
		$this->set('isAnsed',$this->isAnsweredAll($imicode));
		$this->set('notAnsedPages',$this->getNotAnsed($imicode));
	}
	private function setYearAndSeason(EntityInterface $imitation){
		//和暦セット
		$this->set('year',$imitation['mf_exa']->jap_year);
		//季節セット
		$this->set('season',$imitation['mf_exa']['exaname']);
		
	}
	private function writeAnsToSsn(ServerRequest $request){
		$imicode = $request->getParam('imicode');
		//遷移元ページのリンク番号
		$befNum = $request->getData("curNum");
		//模擬試験コードか遷移元のページ番号がセットされていない場合何もしない
		if (!isset($imicode) or !isset($befNum)) return;
		//すでに書いたページ番号にtrueを設定
		$this->writeSession(['inputtedPages',$befNum],true);
		//遷移元ページの一番最初の問題番号
		$iniQueBefNum = ( $befNum - 1 ) * 10 + 1;
		for ($qNum = $iniQueBefNum ; $qNum < $iniQueBefNum + 10; $qNum++ ){
			//POSTされた回答と自信度を取得
			$answer = $request->getData("answer_{$qNum}");
			$confidence = $this->request->getData("confidence_{$qNum}");
			//解答と自信度をセッションに書き込む
			$this->writeSession(['answers',$imicode,$qNum], $answer);
			$this->writeSession(['confidences',$imicode, $qNum], $confidence);
		}
	}
	//結果表示
	public function result() {
		//回答入力時
		//TODO:セッションかなんかでPOST元が解答画面かチェック
		if ($this->request->is('post')) {
			$this->writeAnsToSsn($this->request);
		}
		$imicode = $this->request->getParam('imicode');
		//もしどれか未入力の場合はリダイレクト
		if ( !($this->isAnsweredAll($imicode)) ) {
			$this->redirect(
				[ 'action' => 'input' ,
					'imicode' => $imicode
				]
			);
		}
	}
	//入力されていないページ一覧を取得
	private function getNotAnsed (int $imicode):array{
		$notAnsedPages = array_fill(0,8,true);
		//1-10,11-20などの範囲でどれか一問でも未入力のとき、
		//ページ番号=>falseが配列に入る
		foreach (range(0,7) as $pageNum){
			foreach (range(1,10) as $lowNum) {
				$qNum = $pageNum * 10 + $lowNum;
				$answer = $this->readSession(['answers',$imicode,$qNum]);
				$conf = $this->readSession([ 'confidences', $imicode, $qNum ]);
				if (!(isset($answer)) || !(isset($conf))) {
					$notAnsedPages[$pageNum] = false;
					break;
				}
			}
		}
		return $notAnsedPages;
	}
	//回答が全てのページで入力されているか
	private function isAnsweredAll(int $imicode) :bool {
		return in_array(false,$this->getNotAnsed($imicode));
	}
	//セッションから値を読み込む
	//引数は値の場所の配列
	private function readSession(array $tagArray) {
		$session = $this->request->session();
		return $session->read($this->genSsnTag($tagArray));
	}
	//セッションに値を書き込む
	//引数は値の場所の配列と書き込むデータ
	private function writeSession(array $tagArray,$data) {
		$session = $this->request->session();
		$session->write($this->genSsnTag($tagArray), $data);
	}
	//配列からセッションの場所(文字列)を生成
	private function genSsnTag( array $children): String{
		return implode(".", $children);
	}
	
}
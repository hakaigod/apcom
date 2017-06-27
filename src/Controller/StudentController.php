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
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

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
		//模擬試験合計テーブル
		$this->loadModel('TfSum');
		
		//TODO:この行はセッションが実装されたら消す
		$session = $this->request->session();
		$session->write('StudentID', '13110025');
		
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
		
		
		$regnum = $this->readSession(['StudentID']);
		
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
		$this->set(compact('imicode'));
		//リクエストされたページ番号 範囲は1-8
		$curNum = $this->request->getParam('linkNum');
		//模擬試験コードから試験実施年度と季節を取得
		$imitation = $this->TfImi->getOneAndQes($imicode,10,$curNum);
//		$this->set(compact('imitation'));
		$this->setYearAndSeason($imitation);
		//現在のページ番号をセット
		$this->set(compact('curNum'));
		//問題文セット
		$questions = $imitation['mf_exa']['mf_qes'];
		$this->set(compact('questions'));
		
		//回答入力時(=POST)
		if ($this->request->is('post')) {
			//セッションに解答を書き込む
			$this->writeAnsToSsn($this->request);
		}
		
		//過去入力した選択肢、自信度がセッションに存在する場合
		//既定値としてビューにセットする
		$iniQueAfNum = ( $curNum - 1 ) * 10 + 1;
		$inputtedLog = [];
		for ($qNum = $iniQueAfNum ; $qNum < $iniQueAfNum + 10; $qNum++ ) {
			$inputtedLog['answers'][$qNum] = $this->readSession([ 'answers', $imicode, $qNum ]);
			$inputtedLog['confidences'][$qNum] = $this->readSession(['confidences',$imicode,$qNum]);
		}
		$this->set(compact('inputtedLog'));
		
		//すべてのページが解答されているか
		$this->set('isAnsed',$this->isAnsweredAll($imicode));
		//未解答のページ一覧
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
		if (!isset($imicode) or !isset($befNum)) {
			$this->log("imicode or befNum are not set");
			return;
		}
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
	//解答をDBに送信する
	public function sendAll() {
		//回答入力時
		if ($this->request->is('post')) {
			$this->writeAnsToSsn($this->request);
		}
		
		//もしどれか未入力の場合はリダイレクト
		//TODO:isAnsweredAllにlimit追加して全部を範囲にする
//		if ( !($this->isAnsweredAll($imicode)) ) {
//		$this->redirect(
//			[ 'action' => 'input' ,
//			  'imicode' => $imicode
//			]
//		);
//		}
		
		$imicode = $this->request->getParam('imicode');
		$this->set(compact('imicode'));
		$corrects = $this->TfImi->getOneAndQes($imicode,80);
		$rejoinders = $this->readSession(['answers',$imicode]);
		$regnum = $this->readSession(['StudentID']);
		$confidences = $this->readSession([ 'confidences', $imicode ]);
		
		//TODO:この辺をinputの方に分散する
		//各解答のINSERTクエリを生成
		$insertAnsQuery = $this->TfAns->query()->insert([ 'imicode', 'qesnum', 'regnum', 'rejoinder', 'confidence','correct_answer' ]);
		//合計点数
		$totalScore = 0;
		foreach ($rejoinders as $key => $rejoinder) {
			$answer = $corrects['mf_exa']['mf_qes'][$key - 1]->answer;
			$insertAnsQuery->values([ 'imicode'=>$imicode,
			                          'qesnum'=>  $key,
			                          'regnum'=>  $regnum,
			                          'rejoinder'=>  $rejoinder,
			                          'confidence'=>  $confidences[$key],
			                          'correct_answer' => $answer
			                        ]);
			if ($rejoinder == $answer) {
				$totalScore ++ ;
			}
		}
		$insertSumQuery = $this->TfSum->query()
			->insert(['regnum','imicode','imisum'])
			->values([ 'regnum' => $regnum,
			           'imicode' => $imicode,
			           'imisum' => $totalScore
				]);
		
		$connection = ConnectionManager::get('default');
		//解答と合計のINSERTをトランザクションで行う
//		$connection->transactional(function ($connection) use ($insertAnsQuery,$insertSumQuery) {
//			$insertAnsQuery->execute();
//			$insertSumQuery->execute();
//		});
		$this->redirect([ 'controller' => 'student','action' => 'result' , 'imicode' => $imicode ]);
	}
	
	public function result () {
		//TODO:何回目、合計、平均点
		$imicode = $this->request->getParam('imicode');
		$imiQesAns = $this->TfImi->getOneAndQes($imicode,80);
		$this->set(compact('imiQesAns'));

		//年度
		$year = $imiQesAns['mf_exa']->jap_year;
		$this->set(compact('year'));
		//季節
		$season = $imiQesAns['mf_exa']->exaname;
		$this->set(compact('season'));

		$regnum = $this->readSession(['StudentID']);
		//合計点
		$score = $this->TfSum->find()
			->where(['TfSum.regnum' => $regnum,
			        'TfSum.imicode' => $imicode])
			->first();
		$this->set(compact('score'));
		
		$questions = $imiQesAns['mf_exa']['mf_qes'];
		$this->set(compact('questions'));
		
		$answers = $this->TfAns->find()
			->where(['TfAns.imicode' => $imicode, 'TfAns.regnum' => $regnum] )->toArray();
		$this->set(compact('answers'));
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
		$notAnsedPages = $this->getNotAnsed($imicode);
		unset($notAnsedPages[count($notAnsedPages) - 1 ]);
		return !(in_array(false,$notAnsedPages));
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
<?php
namespace App\Controller;

use App\Model\Table\MfQesTable;
use App\Model\Table\MfStuTable;
use App\Model\Table\TfAnsTable;
use App\Model\Table\TfImiTable;
use App\Model\Table\TfSumTable;
use Cake\Http\ServerRequest;
use Cake\Datasource\EntityInterface;
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
		
		//生徒モデル読み込み
		$this->loadModel('MfStu');
		
		//TODO:この行はセッションが実装されたら消す
		$session = $this->request->session();
		$session->write('StudentID', '13120023');
		
	}
	
	//ユーザマイページに表示される画面
	public function summary(){
		
		$regnum = $this->readSession(['StudentID']);
		
		//生徒名取得
		$stuName = $this->MfStu->find()
			->where(['MfStu.regnum = ' => $regnum])
			->first()->toArray()['stuname'];
		//生徒名:$stuName
		$this->set(compact('stuName'));
		
		//模擬試験合計、模擬試験情報 取得
		$sums = $this->TfSum->find()
			->contain(['TfImi','TfImi.MfExa'])
			->where(['TfSum.regnum' => $regnum])
			->all();
		$this->set(compact('sums'));
		
		// 1 模擬試験が実施された日付:$dates
		$dates = [];
		// 2 模擬試験が i年{春,秋} j回目:$imiDetails
		$imiDetails = [];
		// 3 各模擬試験の平均点:$averages
		$averages = [];
		// 4 各模擬試験の生徒の合計点:$stuScores
		$stuScores = [];
		foreach ($sums as $sum) {
			// 1
			$dates[] = $sum['tf_imi']['imp_date']->format("n月j日");
			// 2
			$imicode = $sum['imicode'];
			$exanum = $sum['tf_imi']['exanum'];
			$implNum = $this->TfImi->getImplNum($imicode,$exanum) + 1;
			$examDetail = $sum['tf_imi']['mf_exa']->exam_detail;
			$imiDetails[] = "{$examDetail} {$implNum}回目";
			// 3
			$averages[] = $sum['tf_imi']['imisum'] / $sum['tf_imi']['imipepnum'];
			// 4
			$stuScores[] = $sum['imisum'];
		}
		$this->set(compact("dates"));
		$this->set(compact("imiDetails"));
		$this->set(compact('averages'));
		$this->set(compact('stuScores'));
//		$this->set('averages',)
//		trimRow($sums, 'imisum')
		
	
	}
	//模擬試験結果入力画面
	public function input(){
		
		//模擬試験テーブルの主キー:$imicode
		$imicode = $this->request->getParam('imicode');
		$this->set(compact('imicode'));
		//リクエストされたページ番号 範囲は1-8
		$curNum = $this->request->getParam('linkNum');
		//模擬試験コードから試験実施年度と季節を取得
		$imitation = $this->TfImi->getOneAndQes($imicode,10,$curNum);
		$this->setYearAndSeason($imitation);
		//現在のページ番号をセット:$curNum
		$this->set(compact('curNum'));
		//問題文セット:$questions
		$this->set('questions',$imitation['mf_exa']['mf_qes']);
		
		//回答入力時(=POST)
		if ($this->request->is('post')) {
			//セッションに解答を書き込む
			$this->writeAnsToSsn($this->request);
		}
		
		//過去入力した選択肢、自信度がセッションに存在する場合
		//既定値としてビューにセットする:$inputtedLog
		$iniQueAfNum = ( $curNum - 1 ) * 10 + 1;
		$inputtedLog = [];
		for ($qNum = $iniQueAfNum ; $qNum < $iniQueAfNum + 10; $qNum++ ) {
			$inputtedLog['answers'][$qNum] = $this->readSession([ 'answers', $imicode, $qNum ]);
			$inputtedLog['confidences'][$qNum] = $this->readSession(['confidences',$imicode,$qNum]);
		}
		$this->set(compact('inputtedLog'));
		$notAnsedPages =$this->getNotAnsed($imicode);
		//未解答のページ一覧:$notAnsedPages
		$this->set(compact('notAnsedPages'));
		//すべてのページが解答されているか:$isAnsed
		$this->set('isAnsed',$this->isAnsweredAll($notAnsedPages));
	}
	private function setYearAndSeason(EntityInterface $imitation){
		//和暦セット:$year
		$this->set('year',$imitation['mf_exa']->jap_year);
		//季節セット:$season
		$this->set('season',$imitation['mf_exa']->exaname);
		
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
		//模擬試験コード:$imicode
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
	
	//各回の詳細な結果
	public function result () {
		//TODO:何回目、合計、平均点
		//模擬試験コード
		$imicode = $this->request->getParam('imicode');
		//学籍番号
		$regnum = $this->readSession(['StudentID']);
		
		$imiQesAns = $this->TfImi->getOneAndQes($imicode,80);
		//本番試験コード
		$exanum = $imiQesAns->exanum;
		
		//年度:$year
		$this->set('year',$imiQesAns['mf_exa']->jap_year);
		//季節:$season
		$this->set('season',$imiQesAns['mf_exa']->exaname);
		//同じ本番試験が模擬試験として実施された回数
		$implNum = $this->TfImi->getImplNum($imicode,$exanum) + 1;
		$this->set(compact('implNum'));
		//平均点:$average
		$average = 0;
		if (isset($imiQesAns) && $imiQesAns->imipepnum > 0) {
			$average = $imiQesAns->imisum / $imiQesAns->imipepnum;
		}
		$this->set(compact('average'));
		//問題:$questions
		$this->set("questions",$imiQesAns['mf_exa']['mf_qes']);
		//解答:$answers
		$answers = $this->TfAns->find()
			->where(['TfAns.imicode' => $imicode, 'TfAns.regnum' => $regnum] )->toArray();
		$this->set(compact('answers'));
		//合計点:$score
		$score = $this->TfSum->find()
			->where(['TfSum.regnum' => $regnum, 'TfSum.imicode' => $imicode])
			->first();
		$this->set(compact('score'));
		//正答率:$correctRate
		$this->set('correctRates',$this->getCorrectRates($imicode,$imiQesAns['imipepnum']));
		//平均自信度:$confAvg
		$this->set('confAvg',$this->getConfAvg($imicode,$imiQesAns['imipepnum']));
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
	private function isAnsweredAll(array $notAnsedPages) :bool {
		unset($notAnsedPages[count($notAnsedPages) - 1 ]);
		return !(in_array(false,$notAnsedPages));
	}
	//セッションから値を読み込む
	//引数は値の場所の配列
	private function readSession(array $tagArray) {
		$session = $this->request->session();
		return $session->read($this->getSsnTag($tagArray));
	}
	//セッションに値を書き込む
	//引数は値の場所の配列と書き込むデータ
	private function writeSession(array $tagArray,$data) {
		$session = $this->request->session();
		$session->write($this->getSsnTag($tagArray), $data);
	}
	//配列からセッションの場所(文字列)を生成
	private function getSsnTag( array $children): String{
		return implode(".", $children);
	}
	
	private function getCorrectRates(int $imicode,int $imipepnum = null):array {
		
		if ($imipepnum == null) {
			$imipepnum = $this->getImiPepNum($imicode);
		}
		if ($imipepnum == 0) {
			return [];
		}
		//問題ごとに何人正解したか
		//ただし0は出ない
		$query = $this->TfAns->find();
		$result = $query
			->select([ 'subQesnum' => 'qesnum',
			           'rate' => "count(*) / {$imipepnum}"])
			->where([ 'rejoinder = correct_answer', 'imicode' => $imicode])
			->group(['qesnum'])
			->toArray();
		$resultAndZero = [];
		$k = 0;
		for ($i = 0;$i < 80; $i++ ) {
			$rate = 0;
			if ( $k < sizeof($result) && ($result[$k]['subQesnum'] - 1) == $i) {
				$rate = $result[$k]['rate'];
				$k++;
			}
			$resultAndZero[$i] = $rate;
		}
		return $resultAndZero;
	}
	private function getConfAvg(int $imicode,int $imipepnum = null): array{
		if ($imipepnum == null) {
			$imipepnum = $this->getImiPepNum($imicode);
		}
		if ($imipepnum == 0) {
			return [];
		}
		
		return $this->TfAns->find()
			->select(['qesnum','avg' => 'sum(confidence)'])
			->where(['imicode' => $imicode])
			->group([ 'qesnum' ])
			->toArray();
		
	}
	private function getImiPepNum (int $imicode):array {
			$imitation = $this->TfImi->find()
				->where([ 'imicode' => $imicode])
				->first()->toArray();
			return $imitation['imipepnum'];
	}
	private function trimRow($data,$rowName) {
		if ($data instanceof EntityInterface) {
			$result=[];
			foreach ($data as $item) {
				$result[] = $item->get($rowName);
			}
			return $result;
		}else{
			return null;
		}
	}
}
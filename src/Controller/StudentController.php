<?php
namespace App\Controller;
use App\Model\Entity\TfAn;
use App\Model\Entity\TfImi;
use App\Model\Entity\TfSum;
use App\Model\Table\MfFieTable;
use App\Model\Table\MfQesTable;
use App\Model\Table\MfStuTable;
use App\Model\Table\TfAnsTable;
use App\Model\Table\TfImiTable;
use App\Model\Table\TfSumTable;
use Cake\Http\ServerRequest;
use Cake\Datasource\ConnectionManager;
const Q_TOTAL_NUM = 80;
const Q_NUM_PER_PAGE = 10;
const MAX_PAGE_NUM = Q_TOTAL_NUM / Q_NUM_PER_PAGE;
//本当はテーブルに書いたほうがいいけども文字数が
const TECH_NUM = 1;
const TECH_WEIGHT = 2;
const MAN_NUM = 2;
const MAN_WEIGHT = 10;
const STR_NUM = 3;
const STR_WEIGHT = 5;
/**
 * @property TfAnsTable TfAns
 * @property MfStuTable MfStu
 * @property TfImiTable TfImi
 * @property MfQesTable MfQes
 * @property TfSumTable TfSum
 * @property MfFieTable MfFie
 */
class StudentController extends AppController
{
	
	public function initialize(){
		parent::initialize();
		$this->set('headerlink', $this->request->webroot . 'Manager');
		
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
		//分野モデル読み込み
		$this->loadModel('MfFie');
		//試験モデル読み込み
		$this->loadModel('MfExa');
		
		
		
		$regnumFromReq = $this->request->getParam('id');
		$regnumFromSsn = $this->readSession(['userID']);
		//TODO:管理者用の条件分岐
		//TODO:ログインしていないとき、ログイン画面に飛ばす条件分岐
		//セッションの学籍番号とURLの学籍番号が違うとき、セッションの方にリダイレクト
		if ($regnumFromReq != null && $regnumFromReq != $regnumFromSsn) {
			$this->log("The required regnum is not your regnum in session");
			$this->redirect([ 'controller' => 'student','action' => 'summary' , 'id' => $regnumFromSsn ]);
			return;
		}
		//生徒名:$username
		$username = $this->MfStu->find()
			->select(['stuname'])
			->where([ 'MfStu.regnum = ' => $regnumFromSsn ])
			->first()->toArray()[ 'stuname' ];
		$this->set(compact('username'));
		//リンクを生成するための学籍番号:$userID
		$this->set("userID",$regnumFromSsn);
	}
	
	//ユーザマイページに表示される画面
	public function summary(){
		
		$regnum = $this->readSession(['userID']);
		
		//模擬試験合計、模擬試験情報 取得
		$imitations = $this->TfImi->find()
			->contain([ 'MfExa','TfSum' => function($q) use ($regnum) {
				return $q->where(['regnum' => $regnum] );}])
			->orderDesc('imicode')
			->all();
		
		$imiDetails = [];
		//ジャンルごとの平均が入る
		$userAvg = $wholeAvg = [ "count" => 0, "tech" => 0, "man" => 0, "str" => 0 ];
		foreach ($imitations as $imi) {
			if ( !( $imi instanceof TfImi) ) {
				$this->log('$imi is not instanceof TfImi');
				return;
			}
			$imicode = $imi->imicode;
			//ユーザのその回での点数
			$score  = null;
			//その模擬試験を受験している場合
			if ((count($imi['tf_sum']) === 1) ) {
				$tfSumEntity = $imi['tf_sum'][0];
				if ( !($tfSumEntity instanceof TfSum)) {
					$this->log('$tfSumEntity is not instanceof TfSum');
					return;
				}
				$score = $tfSumEntity->_getStudentSum();
				//ユーザのジャンルごとの合計に加算
				$userAvg = $this->calcGenreSum($userAvg, $tfSumEntity->_getGenreArray());
			}
			//模擬試験コード,試験名,日付,平均点,ユーザの点数,順位
			$imiDetails[] = [
				'imicode' => $imi->imicode,
				'name' => $imi->_getName($this->TfImi),
				'date' => $imi->imp_date->format("m/d"),
				'avg' => $imi->_getAverage(),
				'score' => $score,
				'rank' => ($score !== null)?$this->TfSum->getRank($imicode, $score):null
			];
			//全体のジャンルごとの合計に加算
			$wholeAvg = $this->calcGenreSum($wholeAvg, $imi->_getGenreArray());
		}
		//平均にするため試験回数で割る
		$wholeAvg = $this->calcGenreAvg($wholeAvg);
		$userAvg = $this->calcGenreAvg($userAvg);
		//模擬試験回の名前や平均などの情報の配列:$imiDetails
		$this->set(compact('imiDetails'));
		//ユーザのジャンルごとの平均:$userAvg
		$this->set(compact('userAvg'));
		//全体のジャンルごとの平均:$wholeAvg
		$this->set(compact('wholeAvg'));
	}
	
	//ジャンルごとの合計をとる
	public function calcGenreSum( array $sum, array $single):array
	{
		//個数を増やす
		$sum['count']++;
		foreach ($sum as $key => &$value) {
			if ($key == 'count') continue;
			$value += $single[$key];
		}
		return $sum;
	}
	//レーダーチャートに合わせるため100分率に変換
	public function calcGenreAvg( array $sum):array
	{
		if ($sum['count'] > 0) {
			return [
				round($sum[ 'tech' ]  /  $sum[ 'count' ] * TECH_WEIGHT  ,1),
				round($sum[ 'man' ]  /  $sum[ 'count' ] * MAN_WEIGHT ,1),
				round($sum[ 'str' ]  /  $sum[ 'count' ] * STR_WEIGHT  ,1)];
		}else{
			return [0,0,0];
		}
	}
	
	//模擬試験結果入力画面
	public function input(){
		
		//模擬試験テーブルの主キー:$imicode
		$imicode = $this->request->getParam('imicode');
		$this->set(compact('imicode'));
		//リクエストされたページ番号 範囲は1-8
		$curNum = $this->request->getParam('linkNum');
		//模擬試験コードから試験実施年度と季節,問題を取得
		$imitation = $this->TfImi->getOneAndQes($imicode,Q_NUM_PER_PAGE,$curNum);
		if (!isset($imitation) || !($imitation instanceof TfImi)) {
			$this->log('failed to get an imitation entity');
			return;
		}
		$imiName = $imitation->_getName($this->TfImi);
		//模擬試験名:$imiName
		$this->set(compact('imiName'));
		//現在のページ番号をセット:$curNum
		$this->set(compact('curNum'));
		//問題文セット:$questions
		$this->set('questions',$imitation['mf_exa']['mf_qes']);
		$inputtedLog['answers'] = array_fill(1, Q_TOTAL_NUM , null);
		$inputtedLog['confidences'] = array_fill(1, Q_TOTAL_NUM , null);
		//最初のアクセスのとき
		if ( $this->readSession(['answers',$imicode]) === null ){
			//過去入力した選択肢、自信度をDBから読み込む
			$answersFromDB = $this->TfAns->find()
				->where([ 'imicode' => $imicode, 'regnum' => $this->readSession([ 'userID' ]) ])
				->all();
			foreach ($answersFromDB as $answer) {
				if ($answer instanceof TfAn) {
					$inputtedLog['answers'][$answer->qesnum] = $answer->rejoinder;
					$inputtedLog['confidences'][$answer->qesnum] = $answer->confidence;
				}
			}
			$this->writeSession([ 'answers',$imicode], $inputtedLog['answers']);
			$this->writeSession([ 'confidences',$imicode], $inputtedLog['confidences']);
		}else {
			//回答入力時(=POST)はセッションに解答を書き込む
			if ( $this->request->is('post') ) $this->writeAnsToSsn($this->request);
			//過去入力した選択肢、自信度がセッションに存在する場合
			//既定値としてビューにセットする:$inputtedLog
			$iniQueAfNum = ( $curNum - 1 ) * Q_NUM_PER_PAGE + 1;
			$inputtedLog = [];
			for ( $qNum = $iniQueAfNum; $qNum < $iniQueAfNum + Q_NUM_PER_PAGE; $qNum++ ) {
				$inputtedLog[ 'confidences' ][ $qNum ] = $this->readSession([ 'answers', $imicode, $qNum ]);
				$inputtedLog[ 'answers' ][ $qNum ] = $this->readSession([ 'confidences', $imicode, $qNum ]);
			}
		}
		$this->set(compact('inputtedLog'));
		$notAnsedPages = $this->getNotAnsed($imicode);
		//未解答のページ一覧:$notAnsedPages
		$this->set(compact('notAnsedPages'));
		//1-7のページが解答されているか:$isAnsed
		unset($notAnsedPages[ count($notAnsedPages) - 1 ]);
		$this->set('isAnsed', $this->isAnsweredAll($notAnsedPages));
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
		$iniQueBefNum = ( $befNum - 1 ) * Q_NUM_PER_PAGE + 1;
		$validationFailed = false;
		for ($qNum = $iniQueBefNum ; $qNum < $iniQueBefNum + Q_NUM_PER_PAGE; $qNum++ ){
			//POSTされた回答と自信度を取得
			$answer = h($request->getData("answer_{$qNum}"));
			$confidence = h($this->request->getData("confidence_{$qNum}"));
			//値のチェック
			if ( 0 <= $answer && $answer <= 4 && 1 <= $confidence && $confidence <= 3) {
				//解答と自信度をセッションに書き込む
				$this->writeSession([ 'answers', $imicode, $qNum ], $answer);
				$this->writeSession([ 'confidences', $imicode, $qNum ], $confidence);
			}else{
				$validationFailed = true;
			}
		}
		if ($validationFailed) $this->log("validation failed on " . $befNum);

	}
	//解答をDBに送信する
	public function sendAll() {
		//回答入力時
		if ($this->request->is('post')) {
			$this->writeAnsToSsn($this->request);
		}
		$regnum = $this->readSession(['userID']);
		
		$imicode = $this->request->getParam('imicode');
		//模擬試験コード:$imicode
		$this->set(compact('imicode'));
		
		//もし一つでも未入力の場合は何もしない
		if ( !($this->isAnsweredAll($this->getNotAnsed($imicode))) ) {
			$this->set('answeredAll',false);
			$this->log('All rejoinders should be inputted.');
			return;
		}
		$this->set('answeredAll',true);
		$corrects = $this->TfImi->getOneAndQes($imicode,Q_TOTAL_NUM);
		if ($corrects === null) {
			$this->set('imicodeInRange',false);
			$this->log('imicode is out of range.');
			return;
		}
		$this->set('imicodeInRange',true);
		$rejoinders = $this->readSession(['answers',$imicode]);
		$confidences = $this->readSession([ 'confidences', $imicode ]);
		//各解答のINSERTクエリを生成
		$insertAnsQuery = $this->TfAns->query()->insert([ 'imicode', 'qesnum', 'regnum', 'rejoinder', 'confidence','correct_answer' ]);
		//各ジャンルの合計点
		$scores = [TECH_NUM => 0, MAN_NUM => 0, STR_NUM => 0];
		foreach ($rejoinders as $key => $rejoinder) {
			$question = &$corrects['mf_exa']['mf_qes'][$key - 1];
			$insertAnsQuery->values([ 'imicode'=> $imicode,
			                          'qesnum'=>  $key,
			                          'regnum'=>  $regnum,
			                          'rejoinder'=>  $rejoinder,
			                          'confidence'=>  $confidences[$key],
			                          'correct_answer' => $question->answer
			                        ]);
			//正解の選択肢だったら
			if ($rejoinder == $question->answer) $scores [$question->fienum] ++;
		}
		$insertSumQuery = $this->TfSum->query()
			->insert(['regnum','imicode','technology_sum','management_sum','strategy_sum'])
			->values([ 'regnum' => $regnum,
			           'imicode' => $imicode,
			           'technology_sum' => $scores[TECH_NUM],
			           'management_sum' => $scores[MAN_NUM],
			           'strategy_sum' => $scores[STR_NUM]
			         ]);
		$connection = ConnectionManager::get('default');
		//解答と合計のINSERTをトランザクションで行う
		$genOnDup = function (array $names) {
			$state = "ON DUPLICATE KEY UPDATE ";
			for ($i = 0; $i < count($names); $i ++ ) {
				$state .= "`{$names[$i]}` = VALUES(`{$names[$i]}`)";
				if ($i !== count($names) - 1) {
					$state .= ", ";
				}
			}
			return $state;
		};
		//もしすでに行が存在する場合は上書き
		$insertAnsQuery = $insertAnsQuery->epilog($genOnDup(['rejoinder','confidence','correct_answer']));
		$insertSumQuery = $insertSumQuery->epilog($genOnDup(['technology_sum','management_sum','strategy_sum']));
		//トランザクションの実行結果
		$result = false;
		try {
			//http://ytrewq.hatenablog.com/entry/2017/07/01/115732
			$result = $connection->transactional(function ( $connection ) use ( $insertAnsQuery, $insertSumQuery ) {
				$insertSumQuery->execute();
				$insertAnsQuery->execute();
				$this->log("transaction is successfully executed");
				return true;
			});
		}catch (\PDOException $e) {
			$this->log($e->getMessage());
		}
		$this->set(compact('result'));
		//結果画面にリダイレクト
		if ($result) {
			//セッション内の解答削除
			$this->removeSession(['confidences', $imicode]);
			$this->removeSession(['answers', $imicode]);
			$this->redirect([ 'controller' => 'student', 'action' => 'result',
			                  'id'         => $regnum, 'imicode' => $imicode ]);
		}
	}
	
	//各回の詳細な結果
	public function result ()
	{
		//模擬試験コード
		$imicode = $this->request->getParam('imicode');
		//学籍番号
		$regnum = $this->readSession([ 'userID' ]);
		
		$imiQesAns = $this->TfImi->getOneAndQes($imicode, Q_TOTAL_NUM);
		//もし実施されていない模擬試験ならば変数をセットしない
		if ( $imiQesAns === null ) {
			$this->log("imicode is out of range");
			return;
		}
		//本番試験コード
		$exanum = $imiQesAns->exanum;
		//試験名:$exaname
		$this->set('exaname', $imiQesAns->_getName($this->TfImi));
		//年度:$year
		$this->set('year', $imiQesAns[ 'mf_exa' ]->jap_year);
		//季節:$season
		$this->set('season', $imiQesAns[ 'mf_exa' ]->exaname);
		//同じ本番試験が模擬試験として実施された回数
		$implNum = $this->TfImi->getImplNum($imicode, $exanum) + 1;
		$this->set(compact('implNum'));
		//平均点:$average
		$average = 0;
		if ( isset($imiQesAns) && $imiQesAns->imipepnum > 0 ) {
			$average = $imiQesAns->_getImiSum() / $imiQesAns->imipepnum;
		}
		$this->set(compact('average'));
		//全体のジャンルごとの平均
		$wholeAvg = [
			round($imiQesAns[TfImiTable::TECH_NAME] / $imiQesAns->imipepnum * TECH_WEIGHT,1),
			round($imiQesAns[TfImiTable::MAN_NAME] / $imiQesAns->imipepnum * MAN_WEIGHT,1),
			round($imiQesAns[TfImiTable::STR_NAME] / $imiQesAns->imipepnum * STR_WEIGHT,1)
		];
		$this->set(compact('wholeAvg'));
		//問題:$questions
		$this->set("questions", $imiQesAns[ 'mf_exa' ][ 'mf_qes' ]);
		//解答:$answers
		$answers = $this->TfAns->find()
			->where([ 'TfAns.imicode' => $imicode, 'TfAns.regnum' => $regnum ])->toArray();
		$this->set(compact('answers'));
		//生徒の合計点:$score
		$score = $this->TfSum->find()
			->where([ 'TfSum.regnum' => $regnum, 'TfSum.imicode' => $imicode ])
			->first();
		//レーダーチャートに表示する、ユーザのジャンルごとの合計点:$userScore
		$userScore = [
			$score[TfSumTable::TECH_NAME] * TECH_WEIGHT,
			$score[TfSumTable::MAN_NAME] * MAN_WEIGHT,
			$score[TfSumTable::STR_NAME] * STR_WEIGHT];
		$this->set(compact('userScore'));
		if ( isset($score) && $score instanceof TfSum ) {
			$score = $score->_getStudentSum();
		} else {
			$score = 0;
		}
		$this->set(compact('score'));
		//順位:$rank
		$rank = $this->TfSum->getRank($imicode, $score);
		$this->set(compact('rank'));
		//正答率:$correctRates
		$this->set('correctRates', $this->getCorrectRates($imicode, $imiQesAns[ 'imipepnum' ]));
		//ジャンルごとの分布:$barNumbers
		$barNumNonZero = $this->TfSum->find()->select(
			[ 'score_floor' => "TRUNCATE(("
				. TfSumTable::TECH_NAME . "+"
				. TfSumTable::MAN_NAME . "+"
				. TfSumTable::STR_NAME . " ) * 1.25,-1)  ",
			  'score_number' => 'count(*)' ])
			->where(['imicode' => $imicode])
			->group([ 'score_floor' ])->toArray();
		$this->set(compact('barNumbers'));
		$barNumHasZero = array_fill(0,11,0);
		foreach($barNumNonZero as $value) {
			$barNumHasZero[(int)($value['score_floor']/10)] = round($value['score_number'] / $imiQesAns->imipepnum * 100,1);
		}
		$this->set("barNumbers",$barNumHasZero);
	}
	
	private function getCorrectRates( int $imicode, int $imipepnum ): array
	{
			//誰も受験していないとき、空の配列を返す
			if ( $imipepnum == 0 ) return [];
			//問題ごとに何人正解したか
			//ただし0は出ない
			$correctRatesNonZero = $this->TfAns->find()->select([ 'subQesnum' => 'qesnum',
			                                                      'rate'      => "count(*) / {$imipepnum}" ])
				->where([ 'rejoinder = correct_answer', 'imicode' => $imicode ])
				->group([ 'qesnum' ])
				->toArray();
			$this->set(compact('correctRatesNonZero'));
			//無い問題番号を0で埋める
			$resultAndZero = array_fill(0, Q_TOTAL_NUM, 0);
			foreach ( $correctRatesNonZero as $rate ) {
				$resultAndZero[ $rate[ 'subQesnum' ] - 1 ] = $rate[ 'rate' ];
			}
			
			return $resultAndZero;
	}
	//入力されていないページ一覧を取得
	private function getNotAnsed (int $imicode):array{
		$notAnsedPages = array_fill(0,MAX_PAGE_NUM,true);
		//1-10,11-20などの範囲でどれか一問でも未入力のとき、
		//ページ番号=>falseが配列に入る
		foreach (range(0,MAX_PAGE_NUM - 1) as $pageNum){
			foreach (range(1,Q_NUM_PER_PAGE) as $lowNum) {
				$qNum = $pageNum * Q_NUM_PER_PAGE + $lowNum;
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
	private function removeSession(array $tagArray){
		$session = $this->request->session();
		$session->delete($this->getSsnTag($tagArray));
	}
	//配列からセッションの場所(文字列)を生成
	private function getSsnTag( array $children): String{
		return implode(".", $children);
	}
	
	//一問一答ジャンル選択画面
	public function qaaSelectGenre()
	{
	}
	
	//一問一答出題画面
	public function qaaQuestion()
	{
		//qaaSelectGenre 選択したジャンルの取得
		$getGenre=$this->request->getData('genre');
		//ctpに送る
		$this->set('getGenre',$getGenre);
		//ルートから番号の取得(回答した回数になる)
		$qNum=$this->request->getParam('question_num');
		$this->set('qNum',$qNum);
		//指定したジャンルのクエリを取得する
		$question = $this->MfQes->find()
			->contain(['MfExa','MfFie'])
			->WHERE(['MfQes.fienum IN' => $getGenre])
			->ORDER(['qesnum' => 'ASC'])
			//何行飛ばすか
			->OFFSET($qNum)
			//1行だけ出力する
			->first();
//        print_r($question);
		//問題内容の表示
		$this->set('question',$question);
	}
	
	
	//年度選択画面
	public function yearSelection()
	{
		//実施された本番一覧を取得
		$exams=$this->MfExa->find()->toArray();
		$this->set(compact('exams'));
		$imitations=$this->TfImi->find()->toArray();
		
		//本番試験番号がキー、その平均点がバリューの要素を追加していく
		$averages=[];
		//本番1つにつき、授業模擬はゼロから複数回実施されているので、
		//複数の場合はその平均をとる
		foreach($exams as $exam_value) {   //本番テーブル
			//試験を受けた合計人数
			$people_sum = 0;
			//試験の全体での合計点数
			$point_sum = 0;
			foreach ($imitations as $imi_value) {                     //模擬試験テーブル
				if (($exam_value->exanum) == ($imi_value->exanum)) {   //試験回番号が一致した場合
					//合計人数を更新
					$people_sum += $imi_value->imipepnum;
					//合計点数(3つの分野の合計点数を加算)を更新
					$point_sum += $imi_value->strategy_imisum + $imi_value->technology_imisum + $imi_value->management_imisum;
				}
			}
			//0で割るとエラーになるため
			if ($people_sum == 0) {
				$averages[$exam_value->exanum] = '[まだ受験者がいません]';
			} else {
				//小数点を切り捨てるためにfloor関数を使う
				$averages[$exam_value->exanum] = floor(intval($point_sum) / $people_sum);
			}
		}
		$this->set(compact('averages'));
		
		//各年度の全国合格率(チンパン)
		$passRate=[22.7,20.5,19.2,18.5,20.1,20.2,19.0,23.4,20.5,21.4];
		$this->set(compact('passRate'));
		
		
//	    結果画面→年度選択画面に戻り、今度は別の年度の問題を解こうとした際に
//      残ったセッションが影響し、正答数カウントの無限ループが行われたため、セッションを削除
		$this->removeSession(['practiceAnswers']);
	}
	
	//解答画面
	public function practiceExam()
	{
		//exanumは文字列
		$exanum = $this->request->getParam("exanum");
		//qesnumは整数
		$qesnum = $this->request->getParam("qesnum");
		//POSTされたラジオボタンの値
		$ansSelect = $this->request->getData('ansSelect');
		$this->set(compact('exanum'));
		
		//保持してるラジオボタンの値を1問分返す
		$ansed = $this->readSession(['practiceAnswers'])[$exanum][$qesnum];
		$this->set(compact('ansed'));
		
		//実施された本番一覧を取得
		$exams = $this->MfExa->find()
			//テーブル内のexanumから抽出する
			->where(['MfExa.exanum' => $exanum])
			//配列として返されるので単数として受け取る
			->first();
		$this->set(compact('exams'));
		
		$qes = $this->MfQes->find()
			->where(['MfQes.qesnum' => $qesnum, 'MfQes.exanum' => $exanum])
			->first();
		$this->set(compact('qes'));
		
		//スコア画面にデータを送る
		$this->score();
		//セッション処理関数にデータを送る
		$this->intoQes();
	}
	
	//全問試験用のセッション処理関数
	public function intoQes(){
		//exanumは文字列型
		$exanum = $this->request->getParam("exanum");
		//qesnumは整数型
		$qesnum = $this->request->getParam("qesnum");
		//POSTされたラジオボタンの値
		$ansSelect = $this->request->getData('ansSelect');
		$this->set(compact('exanum'));
		
		//セッションpracticeAnswersが空なら80個のnullを入れて初期化する
		if(empty($this->readSession(['practiceAnswers']))){
			$practiceLog['answers'] = array_fill(1, Q_TOTAL_NUM, null);
			// practiceAnswersの中にexanumの配列を作る
			$this->writeSession(['practiceAnswers', $exanum], $practiceLog['answers']);
		}
		
		// practiceAnswersの中のexanumの中にqesnumの配列を作る
		$this->writeSession(['practiceAnswers', $exanum, $qesnum + $this->request->getData('into_ques')], $ansSelect);
	}
	

//結果画面
	public function score(){
		//セッション処理関数にデータを送る
		$this->intoQes();
		//exanumは文字列型
		$exanum = $this->request->getParam("exanum");
		$this->set(compact('exanum'));
		
		//実施された本番一覧を取得
		$exams = $this->MfExa->find()
			//テーブル内のexanumから抽出する
			->where(['MfExa.exanum' => $exanum])
			//配列として返されるので単数として受け取る
			->first();
		$this->set(compact('exams'));
		
		//解答
		$ansbox = $this->MfQes->find()
			->where(['MfQes.exanum' => $exanum])->toArray();
		$this->set(compact('ansbox'));
		
		//保持しているラジオボタンの値を全て返す
		$practice = $this->readSession(['practiceAnswers'])[$exanum];
		$this->set(compact('practice'));
		
		//正答数をカウント
		$sum=0;
		foreach (range(1, 80) as $i ) {
			if ($practice[$i] == $ansbox[$i - 1]->answer) {
				$sum++;
			}
		}
		
		//正答数を1.25倍し、100点満点の点数を出す
		$sum=round($sum * 1.25,2) ;
		$this->set(compact('sum'));
		
		//選択した答え等の判定に使用
		$selectArrayPas=array('ア','イ','ウ','エ');
		$this->set(compact('selectArrayPas'));
	}
}
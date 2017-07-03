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
const TECH_NUM = 1;
const MAN_NUM = 2;
const STR_NUM = 3;


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
		//分野モデル読み込み
		$this->loadModel('MfFie');
		
		//TODO:この行はセッションが実装されたら消す
		$session = $this->request->session();
		$session->write('userID', '13120023');
		
		$regnumFromReq = $this->request->getParam('id');
		$regnumFromSsn = $this->readSession(['userID']);
		//TODO:管理者用の条件分岐
		//TODO:ログインしていないとき、ログイン画面に飛ばす条件分岐
		//セッションの学籍番号とURLの学籍番号が違うとき、セッションの方にリダイレクト
		if ($regnumFromReq != $regnumFromSsn) {
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
				round($sum[ 'tech' ] * 100 / ( $sum[ 'count' ] * 50 ) ,1),
				round($sum[ 'man' ] * 100 / ( $sum[ 'count' ] * 10 ),1),
				round($sum[ 'str' ]  * 100 / ( $sum[ 'count' ] * 20 ) ,1)];
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

    public function yearSelection()
    {
        //このコントローラからMfExaモデルを扱うためにloadModelする
        $this->loadModel('MfExa');
        //実施された本番一覧を取得
        $exams=$this->MfExa->find()->toArray();
        $this->set(compact('exams'));

        //このコントローラからTfImiモデルを扱うためにloadModelする
        $this->loadModel('TfImi');
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
                    //合計点数を更新
                    $point_sum += $imi_value->imisum;
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
    }
    
	

    //URLからパラメータ(試験番号)を受け取るので引数がある(practiceExam/1の右端の部分)
    //何も指定されなかったときnull
    //このexanumの宣言はconfig/routes.phpの$routes->connect('/student/practiceExam/:exanum'にある
    public function practiceExam($exanum = null,$qesnum=null)
    {
	    
	    $this->set(compact('exanum'));
	    
	    //このコントローラからMfExaモデルを扱うためにloadModelする
	    $this->loadModel('MfExa');
	    //実施された本番一覧を取得
	    $exams = $this->MfExa->find()
		    //テーブル内のexanumから抽出する
		    ->where(['MfExa.exanum' => $exanum])
		    //配列として返されるので単数として受け取る
		    ->first();
	    $this->set(compact('exams'));
	
	
	    //このコントローラからMfQesモデルを扱うためにloadModelする
	    $this->loadModel('MfQes');
	    $qes = $this->MfQes->find()
		    ->where(['MfQes.qesnum' => $qesnum, 'MfQes.exanum' => $exanum])
		    ->first();
	    $this->set(compact('qes'));
	    
		//posAnsを呼び出せるようにする
		$this->posAns();
//	    $this->posAns($qes->$qesnum,$qes->$exanum);

//	    if (isset($_POST['ansSelect']) == true) {
//	    }
    }
    
	
    // 年度と問題番号の紐づけを行う
	public function posAns(){
//    	$this->practiceExam($exanum);
  
		
		//$ansSelectを呼び出せるようにする
		
		$ansSelect = $this->request->getData('ansSelect');
		$this->set(compact('ansSelect'));
		//POSTで送られたデータをセッションに書き込む
		$this->writeSession(['answers'],$ansSelect);
//		$this->writeSession(['answers.ansS.exaN.qesN'],$ansSelect,$exanum,$qesnum);
		
		//配列に入れた後、呼び出し元の問題番号に合うように指定すること
		//$sesAnsを呼び出せるようにする
		$sesAns=$this->readSession(['answers']);
		$this->set(compact('sesAns'));
		
	}
	
	
	public function score()
	    {
	    }
    
	    
	//セッションから値を読み込む
	//引数は値の場所の配列
    private function readSession(array $tagArray){
    	$session=$this->request->session();
    	return $session->read($this->getSsnTag($tagArray));
    }
    
	//セッションに値を書き込む
	//引数は値の場所の配列と書き込むデータ
	private function writeSession(array  $tagArray,$data){
    	$session=$this->request->session();
    	$session->write($this->getSsnTag($tagArray),$data);
	}
	
	//配列からセッションの場所(文字列)を生成
	private function  getSsnTag( array $children): String{
		return implode(".",$children);
	}
 
}
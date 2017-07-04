<?php
namespace App\Controller;

use App\Model\Entity\MfExa;
use App\Model\Entity\MfQe;
use App\Model\Table\MfExaTable;
use App\Model\Table\TfAnsTable;
use App\Model\Table\TfImiTable;
use App\Model\Table\MfQesTable;
//use Cake\Utility\String;

/**
 * @property MfExaTable MfExa
 * @property TfImiTable TfImi
 * @property MfQesTable MfQes
 */

class StudentController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->set('headerlink', $this->request->getAttribute('webroot') . 'Student');
//	    $session = $this->request->session();
    }

    public function index()
    {
    }

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
//		$this->posAns();
	    $this->posAns($qes->$qesnum,$qes->$exanum);
	    
//	    if (isset($_POST['ansSelect']) == true) {
//	    }
    }
    
	
    // 年度と問題番号の紐づけを行う
	public function posAns($qesnum,$exanum){
//    	$this->practiceExam($exanum);
		
		//$ansSelectを呼び出せるようにする
		$ansSelect = $this->request->getData('ansSelect');
		$this->set(compact('ansSelect'));
		//POSTで送られたデータをセッションに書き込む
//		$this->writeSession(['answers'],$ansSelect);
		
		//この書き方をすると階層構造 answer->exaN->qesN->ansS となる
		$this->writeSession(['answers.ansS'],$ansSelect);
//		$this->writeSession(['answers.exaN.qesN.ansS'],$exanum,$qesnum,$ansSelect);
		
		//配列に入れた後、呼び出し元の問題番号に合うように指定すること
		//$sesAnsを呼び出せるようにする
		
		$sesAns=$this->readSession(['answers.ansS']);
		$this->set(compact('sesAns'));
	}
	
	
	public function score($exanum=null){
		
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
		
	}
 
	
	    
	//セッションから値を読み込む
	//引数は値の場所の配列
    private function readSession(array $tagArray){
    	$session=$this->request->session();
//	    return $session->read(($tagArray),$data);
    	return $session->read($this->getSsnTag($tagArray));
    }
    
	//セッションに値を書き込む
	//引数は値の場所の配列と書き込むデータ
	private function writeSession(array  $tagArray,$data){
    	$session=$this->request->session();
//    	$session->write(($tagArray),$data);
		$session->write($this->getSsnTag($tagArray),$data);
	
	}
	
	//配列からセッションの場所(文字列)を生成
	private function  getSsnTag( array $children): String{
		return implode(".",$children);
	}
 
}
<?php
namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use App\Model\Table\MfQesTable;

/**
 * @property MfQesTable MfQes
 */

class StudentController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->set('headerlink', $this->request->getAttribute('webroot') . 'Student');
        $this->loadModel('MfQes');
    }

    public function index()
    {
    }

    //一問一答ジャンル選択画面
    public function qaaSelectGenre()
    {
    }

    //一問一答出題画面
    public function qaaQuestion()
    {
        //qaaSelectGenre 選択したジャンルの取得
        $getGenre = $this->request->getQuery('SelectGenre');

//        debug($getGenre);

//        指定したジャンルの問題を取得する
        $this->loadModel('MfQes');
        $question = $this->MfQes->find()
//            総問題数、問題番号、問題文、選択肢1~4、正解、該当する出題ジャンル
//                ->SELECT(['count * as total','qesnum','fienum','question','choice1','choice2','choice3','choice4','answer'])
                ->WHERE(['MfQes.fienum IN' => $getGenre])
                ->ORDER(['qesnum' => 'ASC'])
//            行数の指定
//                ->LIMIT(1)
//            何行飛ばすか
                ->OFFSET(4)
//            1行だけ出力する
                ->first();

//        ルートから番号の取得
        $qnum = $this -> request -> getParam('question_num');

//        問題内容
        $this->set('question',$question);
    }
}
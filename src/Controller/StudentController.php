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

//        $this->log($getGenre);

        //ルートから番号の取得
        $qNum = $this -> request -> getParam('question_num');
        $this -> set('qNum',$qNum);

        //指定したジャンルの問題を取得する
        $this->loadModel('MfQes');
        $question = $this->MfQes->find()
            ->WHERE(['MfQes.fienum IN' => $getGenre])
            ->ORDER(['qesnum' => 'ASC'])
            //何行飛ばすか
            ->OFFSET(5)
            //1行だけ出力する
            ->first();

        //問題内容の表示
        $this->set('question',$question);
    }
}
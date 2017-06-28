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
        $helpers = array('qaa');
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
        $getGenre = $this->request->getData('genre');
        //ctpに送る
        $this -> set('getGenre',$getGenre);
//        print_r($getGenre);
//        $this->log($getGenre);

        //ルートから番号の取得(回答した回数になる)
        $qNum = $this -> request -> getParam('question_num');
//        debug($qNum);
        $this -> set('qNum',$qNum);

        //指定したジャンルのクエリを取得する
        $this->loadModel('MfQes');
        $question = $this->MfQes->find()
            ->WHERE(['MfQes.fienum IN' => $getGenre])
            ->ORDER(['qesnum' => 'ASC'])
            //何行飛ばすか
            ->OFFSET($qNum)
            //1行だけ出力する
            ->first();

        //問題内容の表示
        $this->set('question',$question);
    }
}
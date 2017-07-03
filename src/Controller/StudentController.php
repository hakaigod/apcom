<?php
namespace App\Controller;

use App\Model\Table\MfExaTable;
use App\Model\Table\MfFieTable;
use App\Model\Table\MfQesTable;

/**
 * @property MfQesTable MfQes
 * @property MfExaTable MfExa
 * @property MfFieTable MfFie
 */

class StudentController extends AppController
{
    public function initialize()
    {
        //画像取得用のヘルパー
        parent::initialize();
        $this->set('headerlink', $this->request->getAttribute('webroot') . 'Student');
        $this->loadModel('MfQes');
        $this->loadModel('MfExa');
        $this->loadModel('MfFie');
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
}
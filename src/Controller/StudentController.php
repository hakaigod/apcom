<?php
namespace App\Controller;

use App\Model\Table\MfQesTable;
use Cake\ORM\TableRegistry;

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
        //qaaSelectGenre アクションからPOSTした値の取得
        $post = $this -> request -> getParam('field');
        $this -> set('aa',$post);
        // 新しいクエリーを始めます。
        $articles = TableRegistry::get('MfQes');
        $query = $articles->find();
        $query->select(['count' => $query->func()->count('*')]);

        //ルートから番号の取得
        $qnum = $this -> request -> getParam('question_num');

        //問題内容
        $this->set('questions', $this -> MfQes -> find()->limit(1)->offset(4));
        //回答
        $this->set('choices', $this -> MfQes -> find()->limit(1)->offset(4));
    }
}
<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use function Sodium\increment;

class StudentController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->set('headerlink', $this->request->webroot . 'Student');
        $this->loadModel('MfQes');
    }

    public function index()
    {
    }

    public function qaaSelectGenre()
    {
    }

    public function qaaQuestion()
    {
        //問番号

        //問題内容
        $this->set('questions', $this -> MfQes -> find()->limit(1)->offset(8));
        //回答
        $this->set('choices', $this -> MfQes -> find()->limit(1)->offset(8));




//        print_r($this -> MfQes -> find()->toarray());配列の形式で出力したい場合
    }

}
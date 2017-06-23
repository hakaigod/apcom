<?php
namespace App\Controller;

use App\Model\Entity\MfExa;
use App\Model\Table\MfExaTable;
use App\Model\Table\TfAnsTable;
use App\Model\Table\TfImiTable;

/**
 * @property MfExaTable MfExa
 * @property TfImiTable TfImi
 */

class StudentController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->set('headerlink', $this->request->getAttribute('webroot') . 'Student');

    }

    public function index()
    {

    }

    public function yearSelection()
    {
        $this->loadModel('MfExa');
        $exams=$this->MfExa->find()->toArray();
        $this->set(compact('exams'));

        $this->loadModel('TfImi');
        $sum=$this->TfImi->find()->toArray();


        //全体の平均点
        $averages=[];
        foreach($exams as $key) {   //試験テーブル
            $avg = 0;
            $count = 0;
            foreach ($sum as $sum_value) {                     //模擬試験テーブル
                If (($key->exanum) == ($sum_value->exanum)) {   //試験会番号が一致した場合
                    $count += $sum_value->imipepnum;            //合計人数
                    $avg += $sum_value->imisum;                 //合計点数
                }
            }
            if ($count == 0) {  //0で割らないため
                $averages[$key->exanum] = '[まだ受験者がいません]';
            } else {
                $averages[$key->exanum] = floor(intval($avg) / $count);
            }
        }
        $this->set(compact('averages'));

    }




    public function scoring()
    {

    }

    public function practiceExam()
    {

    }
}
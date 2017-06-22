<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class StudentController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->set('headerlink', $this->request->webroot . 'Student');

    }

    public function index()
    {

    }

    public function yearSelection()
    {
        $this->loadModel('mf_exa');
        $exams=$this->mf_exa->find();
        $this->set(compact('exams'));
    }

    public function scoring()
    {

    }

    public function practice_exam()
    {

    }
}
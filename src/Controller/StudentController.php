<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class StudentController extends AppController
{
    public function initialize(){
        parent::initialize();

    }

    public function index(){
    	$this->set("headerlink", $this->request->getAttribute('webroot') . "Student");
    }
    public function summary(){
	    $regnum = $this->request->getParam('id');
	    $this->set("headerlink", $this->request->getAttribute('webroot') . "Student/" . $regnum);
	    $this->loadModel('TfAns');
	    $answers = $this->TfAns->find('all',
	    [
	    	'conditions'=>['TfAns.regnum = ' => $regnum]
	    ]);
	    $this->set(compact('answers'));
    }
}

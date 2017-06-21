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
    }

    public function index()
    {
    }

    public function qaaSelectGenre()
    {
    }

    public function qaaQuestion()
    {

    }
}
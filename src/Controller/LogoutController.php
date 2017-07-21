<?php
/**
 * Created by PhpStorm.
 * User: 15110006
 * Date: 2017/07/04
 * Time: 15:04
 */

namespace App\Controller;


/**
 * @property bool|object Session
 */
class LogoutController extends AppController
{

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout('logout');



    }
    public function logout(){


        return $this->redirect($this->Auth->logout());

    }


    public function index()
    {
        $session = $this->request->session();
        $session->destroy();
    }



}
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
        session_start();

        //最初のトークンの生成
        if ($_SESSION['token'] == 0) {
            // トークンをセッションに保存
            $_SESSION['token'] = md5(uniqid(rand(), true));

            //最初のトークンの生成時は初期化
            if (($_SESSION['session_token'] == 0)) {
                $_SESSION["num"] = 0;
            }
        }

        //更新時(同じトークンであるとき)は警告
        if ($_SESSION['token'] == $_SESSION['session_token']) {
            die("不正な処理ですよ。");
            //正しい処理
        } else {
            $_SESSION["num"] += 1;
            $_SESSION['session_token'] = $_SESSION['token'];
            // セッションに保存しておいたトークンの削除
            unset($_SESSION['token']);
        }

        $this->set('num', $_SESSION["num"]);
    }
}

//        //トークンの生成
//        if(isset($token)) {
//            // トークンを発行する
//            $token = md5(uniqid(rand(), true));
//            // トークンをセッションに保存
//            $_SESSION['token'] = $token;
//            // セッションに入れておいたトークンを取得
//            $session_token = isset($_SESSION['token']) ? $_SESSION['token'] : '';
//        }
//
//        // POSTの値からトークンを取得
//        $token = isset($_POST['token']) ? $_POST['token'] : '';
//
//        // セッションに保存しておいたトークンの削除
//        unset($_SESSION['token']);
//        // セッションの保存
//        session_write_close();
//        // セッションの再開
//        session_start();
//
//        // セッションに入れたトークンとPOSTされたトークンの比較
//        if ($token !== $session_token) {
////            die("不正な処理ですよ。");
//            if ($_SESSION["num"] == 0) {
//                $_SESSION["num"] = 1;
////                $this -> set('num',$_SESSION["num"]);
//            } else {
//                $_SESSION["num"] ++;
//
//            }
//        }
//        $this -> set('num',$_SESSION["num"]);
//    }
//}

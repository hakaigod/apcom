<?php
namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use PDO;

class LoginController extends AppController
{
	public function initialize(){
		parent::initialize();
//		$this->set('headerlink', $this->request->webroot . 'Manager');
//		$this->set("username","うんこ");
		$this->viewBuilder()->layout('login');
//require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
        session_start();


        $db['host'] = "localhost";  // DBサーバのURL
        $db['user'] = "cakephp";  // ユーザー名
        $db['pass'] = "pass";  // ユーザー名のパスワード
        $db['dbname'] = "apcom";  // データベース名

// エラーメッセージの初期化
        $errorMessage = "";

// ログインボタンが押された場合
        if (isset($_POST["login"])) {
            // 1. ユーザIDの入力チェック
            if (empty($_POST["regnum"])) {  // emptyは値が空のとき
                if(!empty($_POST["checkbox"]) && $_POST["checkbox"] =="管理者" ) {
                    $errorMessage = '管理者番号が未入力です。';
                    $this->set('errorMessage', $errorMessage);
                }else{
                    $errorMessage = '学籍番号が未入力です。';
                    $this->set('errorMessage', $errorMessage);
                }
            } else if (empty($_POST["password"])) {
                $errorMessage = 'パスワードが未入力です。';
                $this->set('errorMessage', $errorMessage);
            }


            if(!empty($_POST["checkbox"]) && $_POST["checkbox"] =="管理者" ){
                //管理者
                if (!empty($_POST["regnum"]) && !empty($_POST["password"])) {
                    // 入力したユーザIDを格納
                    $admnum = $_POST["regnum"];

                    // 2. ユーザIDとパスワードが入力されていたら認証する
                    $dsn = sprintf('mysql:dbname=%s;  host=%s;  charset=utf8',$db['dbname'] , $db['host']);
	
                    $sql = null;
                    // 3. エラー処理
                    try {
                        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

                        $stmt = $pdo->prepare('SELECT * FROM mf_adm WHERE mf_adm.admnum = ?');
                        $stmt->execute(array($admnum));
                        $password = $_POST["password"];

                        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $hasher = new DefaultPasswordHasher();
                            if ($hasher->check($password,$row['admpass'] )) {
                                session_regenerate_id(true);

                                // 入力したIDのユーザー名を取得
                                $id = $row['admnum'];
                                $sql = "SELECT * FROM mf_adm WHERE mf_adm.admnum = $id";  //入力したIDからユーザー名を取得
                                $stmt = $pdo->query($sql);
                                foreach ($stmt as $row) {
                                    $row['admnum'];  // ユーザー名
                                }
                                $_SESSION["username"] = $row['admname'];
                                $_SESSION["role"] = "manager";
                                $_SESSION["userID"] = $row['admnum'];
                                $this->redirect([ 'controller' => 'Manager','action' => 'index']);

                            } else {
                                // 認証失敗
                                $errorMessage = '管理者番号あるいはパスワードに誤りがあります。';
                                $this->set('errorMessage', $errorMessage);
                            }
                        } else {
                            // 4. 認証成功なら、セッションIDを新規に発行する
                            // 該当データなし
                            $errorMessage = '管理者番号あるいはパスワードに誤りがあります。';
                            $this->set('errorMessage', $errorMessage);
                        }
                    } catch (\PDOException $e) {
                        //$errorMessage = 'データベースエラー';
                        echo $errorMessage;
                        $errorMessage = $sql;
                        $e->getMessage();// でエラー内容を参照可能（デバック時のみ表示）
                        echo nl2br("\n");
                        $this->set('errorMessage', $errorMessage);
                    }
                }
            }else{
                //学生
                if (!empty($_POST["regnum"]) && !empty($_POST["password"])) {
                    // 入力したユーザIDを格納
                    // 入力したユーザIDを格納
                    $regnum = $_POST["regnum"];
                    // 2. ユーザIDとパスワードが入力されていたら認証する
                    $dsn = sprintf('mysql:dbname=%s;  host=%s;  charset=utf8', $db['dbname'], $db['host']);
					$sql = null;
                    // 3. エラー処理
                    try {
                        $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

                        $stmt = $pdo->prepare('SELECT * FROM mf_stu WHERE mf_stu.regnum = ?');
                        $stmt->execute(array($regnum));
                        $password = $_POST["password"];

                        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $hasher = new DefaultPasswordHasher();
                            if ($hasher->check($password, $row['stupass'])) {
                                session_regenerate_id(true);

                                // 入力したIDのユーザー名を取得
                                $id = $row['regnum'];
                                $sql = "SELECT * FROM mf_stu WHERE mf_stu.regnum = $id";  //入力したIDからユーザー名を取得
                                $stmt = $pdo->query($sql);
                                foreach ($stmt as $row) {
                                    $row['regnum'];  // ユーザー名
                                }

                                $_SESSION["username"] = $row['stuname'];
                                $_SESSION["role"] = "student";
                                $_SESSION["userID"] = $row['regnum'];
                                $this->redirect([ 'controller' => 'Student','action' => 'summary','id' => $row['regnum']]);
                            } else {
                                // 認証失敗
                                $errorMessage = '学籍番号あるいはパスワードに誤りがあります。';
                                $this->set('errorMessage', $errorMessage);
                            }
                        } else {
                            // 4. 認証成功なら、セッションIDを新規に発行する
                            // 該当データなし
                            $errorMessage = '学籍番号あるいはパスワードに誤りがあります。';
                            $this->set('errorMessage', $errorMessage);
                        }
                    } catch (\PDOException $exception) {
                        //$errorMessage = 'データベースエラー';
                        echo $errorMessage;
                        $errorMessage = $sql;
                        $exception->getMessage();// でエラー内容を参照可能（デバック時のみ表示）
                        echo nl2br("\n");
                        $this->set('errorMessage', $errorMessage);
                    }
                }
            }
        }
	}

	public function index()
	{
	}
}

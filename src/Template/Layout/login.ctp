<!---->
<?php
////require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
//// セッション開始
//session_start();
//use Cake\Auth\DefaultPasswordHasher;
//
//$db['host'] = "192.168.20.224";  // DBサーバのURL
//$db['user'] = "root";  // ユーザー名
//$db['pass'] = "high01";  // ユーザー名のパスワード
//$db['dbname'] = "apcom";  // データベース名
//
//// エラーメッセージの初期化
//$errorMessage = "";
//
//// ログインボタンが押された場合
//if (isset($_POST["login"])) {
//    // 1. ユーザIDの入力チェック
//    if (empty($_POST["regnum"])) {  // emptyは値が空のとき
//        $errorMessage = '学籍番号が未入力です。';
//    } else if (empty($_POST["password"])) {
//        $errorMessage = 'パスワードが未入力です。';
//    }
//
//
//    if(!empty($_POST["checkbox"]) && $_POST["checkbox"] =="管理者" ){
//        //管理者
//        if (!empty($_POST["regnum"]) && !empty($_POST["password"])) {
//            // 入力したユーザIDを格納
//            $admnum = $_POST["regnum"];
//
//            // 2. ユーザIDとパスワードが入力されていたら認証する
//            $dsn = sprintf('mysql:dbname=%s;  host=%s;  charset=utf8',$db['dbname'] , $db['host']);
//
//            // 3. エラー処理
//            try {
//                $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
//
//                $stmt = $pdo->prepare('SELECT * FROM mf_adm WHERE mf_adm.admnum = ?');
//                $stmt->execute(array($admnum));
//                $password = $_POST["password"];
//
//                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//
//                    $hasher = new DefaultPasswordHasher();
//                    echo $_POST["password"] , $row['admpass'] ,$hasher->check($password,$row['admpass'] );
//                    if ($hasher->check($password,$row['admpass'] )) {
//                        session_regenerate_id(true);
//
//                        // 入力したIDのユーザー名を取得
//                        $id = $row['admnum'];
//                        $sql = "SELECT * FROM mf_adm WHERE mf_adm.admpass = $id";  //入力したIDからユーザー名を取得
//                        $stmt = $pdo->query($sql);
//                        foreach ($stmt as $row) {
//                            $row['admnum'];  // ユーザー名
//                        }
//                        $_SESSION["username"] = $row['admname'];
//                        $_SESSION["role"] = "管理者";
//                        $_SESSION["userID"] = $row['admnum'];
//                        $this->redirect([ 'controller' => 'ManagerController','action' => 'index']);
//
//                        exit();  // 処理終了
//                    } else {
//                        echo "<br><br><br><br><br><br><br><br><br>123";
//                        // 認証失敗
//                        $errorMessage = '管理者番号あるいはパスワードに誤りがあります。';
//                    }
//                } else {
//                    echo $row;
//                    echo "<br><br><br><br><br><br><br><br><br>abc";
//                    // 4. 認証成功なら、セッションIDを新規に発行する
//                    // 該当データなし
//                    $errorMessage = '管理者番号あるいはパスワードに誤りがあります。';
//                }
//            } catch (PDOException $e) {
//                //$errorMessage = 'データベースエラー';
//                echo $errorMessage;
//                $errorMessage = $sql;
//                $e->getMessage();// でエラー内容を参照可能（デバック時のみ表示）
//                echo nl2br("\n");
//                echo $e->getMessage();
//            }
//        }
//    }else{
//        //学生
//        if (!empty($_POST["regnum"]) && !empty($_POST["password"])) {
//            // 入力したユーザIDを格納
//            $regnum = $_POST["regnum"];
//
//            // 2. ユーザIDとパスワードが入力されていたら認証する
//            $dsn = sprintf('mysql:dbname=%s;  host=%s;  charset=utf8', $db['dbname'], $db['host']);
//
//            // 3. エラー処理
//            try {
//                $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//
//                $stmt = $pdo->prepare('SELECT * FROM mf_stu WHERE mf_stu.regnum = ?');
//                $stmt->execute(array($regnum));
//                $password = $_POST["password"];
//
//                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//
//                    $hasher = new DefaultPasswordHasher();
//                    if ($hasher->check($password, $row['stupass'])) {
//                        session_regenerate_id(true);
//
//                        // 入力したIDのユーザー名を取得
//                        $id = $row['regnum'];
//                        $sql = "SELECT * FROM mf_stu WHERE mf_stu.regnum = $id";  //入力したIDからユーザー名を取得
//                        $stmt = $pdo->query($sql);
//                        foreach ($stmt as $row) {
//                            $row['regnum'];  // ユーザー名
//                        }
//
//                        $_SESSION["username"] = $row['stuname'];
//                        $_SESSION["role"] = "学生";
//                        $_SESSION["userID"] = $row['regnum'];
//                        $this->redirect([ 'controller' => 'Studentcontroller','action' => 'summary']);
//                        exit();  // 処理終了
//                    } else {
//                        // 認証失敗
//                        $errorMessage = '学籍番号あるいはパスワードに誤りがあります。';
//                    }
//                } else {
//                    // 4. 認証成功なら、セッションIDを新規に発行する
//                    // 該当データなし
//                    $errorMessage = '学籍番号あるいはパスワードに誤りがあります。';
//                }
//            } catch (PDOException $e) {
//                //$errorMessage = 'データベースエラー';
//                echo $errorMessage;
//                $errorMessage = $sql;
//                $e->getMessage();// でエラー内容を参照可能（デバック時のみ表示）
//                echo nl2br("\n");
//                echo $e->getMessage();
//            }
//        }
//    }
//}
//?>






<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title')?></title>

    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('flat-ui.css') ?>

    <!-- 自作CSS -->
    <?= $this->Html->css('/private/css/default.css') ?>
    <?= $this->Html->css('/private/css/flat_overwrite.css') ?>
    <?= $this->Html->css('/private/css/login/login.css') ?>

    <?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
    <?= $this->Html->script('video.js') ?>
    <?= $this->Html->script('flat-ui.min.js') ?>
    <?= $this->Html->script('application.js') ?>
    <?= $this->Html->script('prettify.js') ?>

    <!-- 自作JS -->


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!-- login   -->

    <?= $this->Html->script('/private/js/login/login.js') ?>

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">応用情報 ど.com</a>
        </div>
    </div>
</nav>
<form id="loginform" name="loginform" action="" method="post">

    <div class="container-fluid all">
        <div class="row">
            <!-- メインカラム -->
            <div class="col-xs-7 col-xs-offset-4" id="col-main">
                <div class="row1">
                    <?= $this->fetch('content') ?>
                    <div class="col-lg-6">
                        <div class="col-lg-12">
                            <br>
                            <div id="text1">学籍番号</div>
                            <!--                        <input href="name" class="form-control">-->
                            <input href="regnum" id="regnum" name="regnum" placeholder="学籍番号を入力" value="<?php if (!empty($_POST["regnum"])) {echo h($_POST["regnum"], ENT_QUOTES);} ?>" class="form-control">
                            <div id="passnot"> <br> </div>パスワード
                            <!--                        <input href="pass" class="form-control">-->
                            <input type="password" id="password" name="password" value="" placeholder="パスワードを入力" class="form-control">
                            <span id="errormessage"><?php if(!empty($this->viewVars['errorMessage'])){echo  $this->viewVars['errorMessage'];}?></span>
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox" name="checkbox" value="管理者"  >　<span id="text2">管理者</span> <br>

                            </div>
                            <div class="col-md-12">
                                <input type="submit" id="login" name="login"  class="btn btn-embossed btn-primary" onclick="" value=" 　ログイン　" ><br>    <br>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>

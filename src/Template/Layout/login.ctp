<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title')?></title>

	<?= $this->Html->meta('icon') ?>

	<?= $this->fetch('meta') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
	<?= $this->Html->css('flat-ui.css') ?>

    <!-- 自作CSS -->
	<?= $this->Html->css('/private/css/default.css') ?>
	<?= $this->Html->css('/private/css/flat_overwrite.css') ?>
	<?= $this->Html->css('/private/css/Login/login.css') ?>


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
            <a class="navbar-brand" href="">
                <img src="<?= $this->request->webroot ?>img/logo.png" class="nabvar-img">
            </a>
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

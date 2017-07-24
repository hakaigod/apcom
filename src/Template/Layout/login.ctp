<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title')?></title>
	<?= $this->Html->css('bootstrap.min.css') ?>
	<?= $this->Html->meta('icon') ?>
	
	<?= $this->fetch('meta') ?>
	
	
	<?= $this->Html->css('flat-ui.css') ?>

    <!-- 自作CSS -->
	<?= $this->Html->css('/private/css/default.css') ?>
	<?= $this->Html->css('/private/css/flat_overwrite.css') ?>
	<?= $this->Html->css('/private/css/Login/Login.css') ?>
	
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
<!--<form id="loginform" name="loginform" action="" method="post">

    <div class="users form">
        <?/*= $this->Flash->render() */?>
        <?/*= $this->Form->create() */?>
        <fieldset>
            <legend><?/*= __('Please enter your username and password') */?></legend>
            <div class="input" id="num">
                <label for="" id="text1">学籍番号</label><br>
                <input type="text" name="regnum" id="regnum">
            </div>
            <div class="input" id="pass">
                <label for="stupass">パスワード<br></label><br>
                <input type="password" name="stupass" id="stupass">
                <label class="checkbox" for="admin">
                    <input id="admin" type="checkbox" data-toggle="checkbox" name="admin" value="管理者">
                    管理者
                </label>
            </div>
            <input type="submit" id="login" name="login"  class="btn btn-embossed btn-primary" onclick="" value=" 　ログイン　" ><br>    <br>
            <br><br><br><br>
    </div>
</form>-->
<br><br><br>
<!--<form id="loginform" name="loginform" action="" method="post">-->
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"></h1>
            <div class="account-wall">
                <img class="profile-img" id="img" name="imgurl" src="<?= $this->request->webroot ?>private/img/00000000.png" alt="">
                <form class="form-signin" id="loginform" name="loginform" action="" method="post">
                    <input type="text" class="form-control" placeholder="Number"  name="regnum" id="regnum"
                           value="<?php if(!empty($_POST)){if(empty($_POST['admin'])){echo $_POST["regnum"];}else{echo $_POST["admnum"];}}?>">
                    <input type="password" class="form-control" placeholder="Password"  name="stupass" id="stupass" >
                    <span id="errormessage"><?php if(!empty($this->viewVars['errorMessage'])){echo  $this->viewVars['errorMessage'];}?></span>
                    <label class="checkbox" for="admin">
                        <input id="admin" type="checkbox" data-toggle="checkbox" name="admin" value="Manager" class="checkboxadmin-parts"
							<?php if(!empty($_POST['admin'])){echo 'checked';} ?>>
                        Manager
                    </label>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" id="submit">
                        Log in</button>
					<?=$this->Form->error ?>
                </form>
            </div>
        </div>
    </div>
</div>
<!--</form>-->
</body>
</html>
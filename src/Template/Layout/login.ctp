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
    <?= $this->Html->script('flat-ui.min.js') ?>
    <?= $this->Html->script('application.js') ?>
    <?= $this->Html->script('prettify.js') ?>

    <!-- 自作JS -->


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!-- login   -->

    <?= $this->Html->script('/private/js/login/login.js') ?>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon.ico">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $this->request->getAttribute("webroot") ?>favicons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= $this->request->getAttribute("webroot") ?>favicons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="48x48" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon-48x48.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon-160x160.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon-196x196.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $this->request->getAttribute("webroot") ?>favicons/favicon-32x32.png">
    <link rel="manifest" href="<?= $this->request->getAttribute("webroot") ?>favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#2d88ef">
    <meta name="msapplication-TileImage" content="<?= $this->request->getAttribute("webroot") ?>favicons/mstile-144x144.png">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
    <div class="col-xs-12">
        <div class="navbar-header">
            <a class="navbar-brand" href="">
                <img src="<?= $this->request->webroot ?>img/logo.png" class="nabvar-img">
            </a>
        </div>
    </div>
</nav>
<br><br><br>
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
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Sign in</button>
                        <?=$this->Form->error ?>
                        <label class="checkbox pull-left" for="admin">
                            <input id="admin" type="checkbox" data-toggle="checkbox" name="admin" value="Manager"
                                <?php if(!empty($_POST['admin'])){echo 'checked';} ?>>
                            Manager
                        </label>
                        <a href="" class="pull-right need-help" id="forget">forget? </a><span class="clearfix"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--</form>-->
</body>
</html>
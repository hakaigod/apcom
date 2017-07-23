<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>応用情報ど.com - <?= $this->fetch('title')?></title>

    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('flat-ui.css') ?>

    <!-- 自作CSS -->
    <?= $this->Html->css('/private/css/default.css') ?>
    <?= $this->Html->css('/private/css/flat_overwrite.css') ?>
    <?= $this->Html->css('/private/css/Logout/logout.css') ?>

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

    <?= $this->Html->script('/private/js/Logout/logout.js') ?>

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
</body>
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
                            <div class="waku">

                                <span id="text1">ログアウトしています．．．</span>
                            </div>
                            <div class="pon"><span id="sec">3</span>
                                <span>秒後にログイン画面に移動します。</span>
                                <div class="hand">
                                    <span>しばらく待っても移動しない場合は、<a href="/apcom/login">ログイン</a>をクリック。</span>
                                </div>
                                <br>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</html>

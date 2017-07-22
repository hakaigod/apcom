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
    <?= $this->Html->css('/private/css/Logout/logout.css') ?>

    <?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
    <?= $this->Html->script('flat-ui.min.js') ?>
    <?= $this->Html->script('application.js') ?>
    <?= $this->Html->script('prettify.js') ?>

    <!-- 自作JS -->


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!-- login   -->

    <?= $this->Html->script('/private/js/Logout/logout.js') ?>
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
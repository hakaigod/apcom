<?php
/***
 *
 * @var \App\View\AppView $this
 * 左上に表示するロゴのリンクのURL生成に使用する、controllerとactionなどを指定
 * @var array $logoLink
 * 右上に表示するユーザのアイコンのパス生成に使用する
 * @var string $userID
 * 右上に表示するユーザの名前
 * @var string $username
 */
?>
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

	<?= $this->fetch('css') ?>

	<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
	<?= $this->Html->script('flat-ui.min.js') ?>
	<?= $this->Html->script('application.js') ?>
	<?= $this->Html->script('prettify.js') ?>

	<!-- 自作JS -->
	<?= $this->Html->script('/private/js/index.js') ?>
	<?= $this->Html->script('/private/js/selectInput.js') ?>

	<?= $this->fetch('script') ?>

    <script src="/nodejs/socket.io/socket.io.js"></script>
    <script type="text/javascript">
        var lastTime = Date.now();
		var socket = io('http://localhost:23000');
//		        var socket = io('http://<?//= $_SERVER['SERVER_ADDR']?>//:3000');
		socket.on('messageFromPHP', function (data) {
			var now = Date.now();
			if (now > lastTime + 3 * 1000) {
				lastTime = now;
				var activityText = $('#activity-text');
				activityText.stop(true,false);
				activityText.animate({opacity:'0'},500,"swing",function(){
						activityText.css({opacity:'1'});
						activityText.text(data);
						//右に完全に隠れた状態から出て来る
						activityText.css({paddingLeft:'70vw'});
						activityText.animate({paddingLeft:"15px"},2500,"swing");
					}
				);
			}
		});
    </script>

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
<nav class=" navbar navbar-inverse navbar-fixed-top" id="navbar">
    <div class="col-xs-offset-2 col-xs-8 ">
        <div class=" navbar-header  navbar-left ">
            <a class="navbar-brand" href="<?= $this->Url->build($logoLink) ?>">
                <img src="<?= $this->request->getAttribute("webroot") ?>img/logo.png" class="nabvar-img">
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <div class="nav navbar-nav navbar-right" id="welcome-user">
                <li class="dropdown navbar-buttton ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="font-weight: 500">
                                                <img src="<?= $this->request->getAttribute("webroot") ?>private/img/identicons/<?=$userID?>.png" class="dropdown-img">
                        ようこそ、<?= $username?:"ERROR!"?>さん
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/apcom/logout">ログアウト</a></li>
                    </ul>
                </li>
            </div>

        </div>

    </div>

</nav>

<div class="all">
    <div id="activity-div" >
        <div class="col-xs-offset-2 col-xs-8" id="activity-text" >aaaaaaaaaaaaa</div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- サイドカラム -->
            <button class="btn btn-hm fui-list floating" id="list"></button>
            <div class="col-xs-2 floating" id="sidebar">
                <div class="row">
                    <button class="btn btn-hm fui-cross" id="cross"></button>
                </div>
                <div class="row">
                    <table class="table table-hover">
						<?= $this->fetch('sidebar')?>
                        <tr class="danger"><td><a href="/apcom/logout">ログアウト</a></td></tr>
                    </table>
                </div>
            </div>

            <!-- メインカラム -->
            <div class="col-xs-8 col-xs-offset-2" id="col-main">
				<?= $this->fetch('content') ?>
            </div>
            <!-- 右サイドカラム -->
            <div class="col-xs-offset-1 col-xs-1">
                <div class="row floating">
                    <div class="" id="reloadbutton">
                        <button class="btn btn-success" onclick="location.reload();">更新</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>

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
	
	<?= $this->fetch('script') ?>
    
    <script src="/nodejs/socket.io/socket.io.js"></script>
    <script type="text/javascript">
        //TODO:IPアドレスをいい感じに設定
        var socket = io('http://<?= $_SERVER['SERVER_ADDR']?>:3000');
        socket.on('messageFromPHP', function (data) {
            console.log(data);
            var activityText = $('#activity-text');
            activityText.stop(true,false);
            activityText.animate({opacity:'0'},500,"swing",function(){
                activityText.css({opacity:'1'});
                activityText.text(data);
                //右に完全に隠れた状態から出て来る
                activityText.css({paddingLeft:'28vw'});
                activityText.animate({paddingLeft:'0'},1700,"swing");
                }
            );
            
        });
    </script>

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
<div class="container-fluid">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?= $this->Url->build($logoLink) ?>">
			<img src="<?= $this->request->getAttribute("webroot") ?>img/logo.png" class="nabvar-img">
		</a>
	</div>
	<div class="navbar-collapse collapse">
		<div class="nav navbar-nav navbar-right">
            <div class="navbar-text" id="activity-div">
                <div id="activity-text"></div>
            </div>
			<li class="dropdown navbar-buttton">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
					<img src="<?= $this->request->getAttribute("webroot") ?>private/img/identicons/<?=$userID?>.png" class="dropdown-img">
					ようこそ、<?= $username?:"ERROR!"?>さん
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">ログアウト</a></li>
				</ul>
			</li>
		</div>
	</div>
</div>
</nav>

<div class="container-fluid all">
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
				<tr class="danger"><td><a href="#">ログアウト</a></td></tr>
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
</body>
</html>

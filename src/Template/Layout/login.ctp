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

	<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
	<?= $this->Html->script('video.js') ?>
	<?= $this->Html->script('flat-ui.min.js') ?>
	<?= $this->Html->script('application.js') ?>
	<?= $this->Html->script('prettify.js') ?>

	<!-- 自作JS -->


	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
<div class="container-fluid">
	<div class="navbar-header">
		<a class="navbar-brand" href="#">応用情報 ど.com</a>
	</div>
<<<<<<< HEAD
=======
	<div class="navbar-collapse collapse">
		<div class="nav navbar-nav navbar-right">
		</div>
	</div>
>>>>>>> e961b691b7afd360df7615655f9e3b302456841d
</div>
</nav>

<div class="container-fluid all">
<div class="row">
	<!-- メインカラム -->
	<div class="col-xs-8 col-xs-offset-2" id="col-main">
		<div class="row">
			<?= $this->fetch('content') ?>
		</div>
	</div>
</div>
</div>
</body>
</html>

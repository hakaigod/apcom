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
	<?= $this->Html->css('/private/css/Manager/addmod.css') ?>
	<?= $this->fetch('css') ?>

	<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
	<?= $this->Html->script('flat-ui.min.js') ?>
	<?= $this->Html->script('application.js') ?>
	<?= $this->Html->script('prettify.js') ?>

	<!-- 自作JS -->
	<?= $this->fetch('script') ?>

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
<div class="container-fluid">
	<div class="navbar-header">
        <a class="navbar-brand" href="<?= $this->Url->build($logoLink) ?>">
			<img src="<?= $this->request->webroot ?>img/logo.png" class="nabvar-img">
		</a>
	</div>
</div>
</nav>

<div class="container-fluid all">
<div class="row">
	<!-- メインカラム -->
	<div class="col-xs-8 col-xs-offset-2" id="col-main">
		<div class="row">
			<?= $this->Flash->render() ?>
			<?= $this->fetch('content') ?>
		</div>
	</div>
</div>
</div>
</body>
</html>

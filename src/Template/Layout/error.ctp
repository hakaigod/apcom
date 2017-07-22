<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

	<?= $this->fetch('meta') ?>

	<?= $this->Html->css('bootstrap.min.css') ?>
	<?= $this->Html->css('flat-ui.css') ?>

	<!-- 自作CSS -->
	<?= $this->Html->css('../private/css/default.css') ?>
	<?= $this->Html->css('../private/css/flat_overwrite.css') ?>
	<?= $this->Html->css('../private/css/Error/error.css') ?>

	<?= $this->fetch('css') ?>

	<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
	<?= $this->Html->script('flat-ui.min.js') ?>
	<?= $this->Html->script('application.js') ?>
	<?= $this->Html->script('prettify.js') ?>

	<!-- 自作JS -->
	<?= $this->Html->script('/private/js/index.js') ?>
	<?= $this->Html->script('/private/js/selectInput.js') ?>

	<?= $this->fetch('script') ?>

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
                        ようこそ、<?= $username ?>さん
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
	<div class="container-fluid center">
		<div class="row">
			<div class="col-xs-offset-2 col-xs-8">
				<div id="content">
					<?= $this->Flash->render() ?>

					<?= $this->fetch('content') ?>
				</div>
			</div>
		</div>
		<div class="row">
			<?= $this->Html->link(__('前のページに戻る'), 'javascript:history.back()', ['class' => 'btn btn-info']) ?>
		</div>
	</div>
</div>
</body>
</html>

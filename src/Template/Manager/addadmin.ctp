<!-- タイトルセット -->
<?= $this->start('title'); ?>
	管理者情報追加
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/addmod.css') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<input type="text" name="strname" class="form-control" placeholder="氏名">
		<input type="text" name="old" class="form-control" placeholder="パスワード">
		<div class="row">
			<button type="submit" class="col-xs-5 btn btn-success">登録</button>
			<a onclick="window.close()" class="col-xs-offset-2 col-xs-5 btn btn-warning">キャンセル</a>
		</div>
	</form>
</div>

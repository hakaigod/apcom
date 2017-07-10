<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学科追加
<?= $this->end(); ?>
<?= $this->start('script'); ?>
	<?= $this->Html->script('/private/js/Manager/DepEditCheck.js') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post" id="depManager">
		<input type="text" name="depname" class="form-control" placeholder="学科名">
		<div class="full buttons">
			<button type="button" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

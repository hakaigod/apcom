<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学生情報修正
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<!-- 学籍番号 -->
		<input type="text" name="strno" class="form-control" placeholder="学籍番号">
		<div class="row">
			<button type="submit" class="col-xs-5 btn btn-success">再発行</button>
			<a onclick="window.close()" class="col-xs-offset-2 col-xs-5 btn btn-warning">キャンセル</a>
		</div>
	</form>
</div>

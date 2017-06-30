<?= $this->start('title'); ?>
<!-- タイトルセット -->
	学生パスワード再発行
<?= $this->end(); ?>

<?= $this->start('script'); ?>
	<!-- jsセット -->
	<?= $this->Html->script('/private/js/Manager/StuEditCheck.js') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post" id="reIssuPass">
		<!-- 学籍番号 -->
		<input type="text" name="stunum" class="form-control" placeholder="学籍番号">
		<div class="full buttons">
			<button type="button" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

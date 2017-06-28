<!-- タイトルセット -->
<?= $this->start('title'); ?>
	管理者情報追加
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<input type="text" name="admname" class="form-control" placeholder="氏名">
		<input type="password" name="admpass" class="form-control" placeholder="パスワード">
		<div class="full buttons">
			<button type="button" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

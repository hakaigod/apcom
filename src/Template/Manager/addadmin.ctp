<!-- タイトルセット -->
<?= $this->start('title'); ?>
	管理者情報追加
<?= $this->end(); ?>
<?= $this->start('script'); ?>
	<?= $this->Html->script('/private/js/Manager/AdminEditCheck.js') ?>
	<?= $this->Html->script('/private/js/Manager/displayPass.js') ?>
<?= $this->end(); ?>


<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post" id="modadmin">
		<input type="text" name="admname" class="form-control" placeholder="氏名">
		<input type="password" name="admNewPass" id="new" class="form-control" placeholder="パスワード">
		<input type="password" name="admNewPass" id="renew" class="form-control" placeholder="パスワード再入力">
		<button type="button" id="passcheck" class="btn btn-xs btn-info">パスワード表示</button>

		<div class="full buttons">
			<button type="button" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

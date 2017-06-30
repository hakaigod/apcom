<!-- タイトルセット -->
<?= $this->start('title'); ?>
	パスワード再設定
<?= $this->end(); ?>

<?= $this->start('script'); ?>
	<?= $this->Html->script('/private/js/Manager/checkPass.js') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form id="resetpass" action="" method="post">
		<!-- 管理者番号 -->
		<input type="text" name="admnum" class="form-control" placeholder="管理者連番">
		<input type="password" name="admOldPass" class="form-control" placeholder="古いパスワード">
		<input type="password" name="admNewPass" id="new" class="form-control" placeholder="新しいパスワード">
		<input type="password" name="admNewPass" id="renew" class="form-control" placeholder="新しいパスワード再入力">

		<div class="full buttons">
			<button type="button" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="button" id="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

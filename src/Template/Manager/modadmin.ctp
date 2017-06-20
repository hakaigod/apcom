<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学生情報修正
<?= $this->end(); ?>

<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/addmod.css') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<input type="text" name="admno" class="form-control" placeholder="管理者連番" readonly="readonly" value="<?= $admnum->admnum; ?>">
		<input type="text" name="admname" class="form-control" placeholder="氏名" value="<?= $admnum->admname; ?>">
		<input type="text" name="pass" class="form-control" placeholder="パスワード" readonly="readonly" value="<?= $admnum->admpass; ?>">
		<label class="checkbox">
			削除
			<input type="checkbox" data-toggle="checkbox" name="deleted_flg" <?= $admnum->deleted_flg ? 'checked="checked"' : ""; ?>>
		</label>
		<div class="row">
			<button type="submit" class="col-xs-5 btn btn-success">修正</button>
			<a onclick="window.close()" class="col-xs-offset-2 col-xs-5 btn btn-warning">キャンセル</a>
		</div>
	</form>
</div>

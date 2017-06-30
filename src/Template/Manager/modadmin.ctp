<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学生情報修正
<?= $this->end(); ?>
<?= $this->start('script'); ?>
	<?= $this->Html->script('/private/js/Manager/AdminEditCheck.js') ?>
<?= $this->end(); ?>


<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post" id="modadmin">
		<input type="text" name="admnum" class="form-control" placeholder="管理者連番" readonly="readonly" value="<?= $admnum->admnum; ?>">
		<input type="text" name="admname" class="form-control" placeholder="氏名" value="<?= $admnum->admname; ?>">
		<label class="checkbox">
			削除
			<input type="checkbox" data-toggle="checkbox" name="deleted_flg" <?= $admnum->deleted_flg ? 'checked="checked"' : ""; ?>>
		</label>
		<div class="full buttons">
			<button type="button" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

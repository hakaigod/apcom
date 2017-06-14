<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学生情報修正
<?= $this->end(); ?>

<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/strmanagers.css') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<input type="text" name="strno" class="form-control" placeholder="学籍番号" value="<?= $regnum->regnum; ?>">
		<input type="text" name="strname" class="form-control" placeholder="氏名" value="<?= $regnum->stuname; ?>">
		<input type="text" name="old" class="form-control" placeholder="学年" value="<?= $regnum->stuyear; ?>">
		<div class="row">
			<label class="checkbox col-xs-6">
				削除
				<input type="checkbox" data-toggle="checkbox" name="deleted_flg" <?= $regnum->deleted_flg ? 'checked="checked"' : ""; ?>>
			</label>
			<label class="checkbox col-xs-6">
				合格
				<input type="checkbox" data-toggle="checkbox" name="graduate_flg" <?= $regnum->graduate_flg ? 'checked="checked"' : ""; ?>>
			</label>
		</div>
		<div class="row">
			<button type="submit" class="col-xs-5 btn btn-success">修正</button>
			<a onclick="window.close()" class="col-xs-offset-2 col-xs-5 btn btn-warning">キャンセル</a>
		</div>
	</form>
</div>

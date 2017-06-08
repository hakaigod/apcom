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
		<input type="text" name="strno" class="form-control" placeholder="学籍番号">
		<input type="text" name="strname" class="form-control" placeholder="氏名">
		<input type="text" name="old" class="form-control" placeholder="学年">
		<label class="checkbox">
			削除
			<input type="checkbox" data-toggle="checkbox">
		</label>
		<label class="checkbox">
			合格
			<input type="checkbox" data-toggle="checkbox">
		</label>
		<div class="row">
			<button type="submit" class="col-xs-5 btn btn-success">登録</button>
			<a onclick="window.close()" class="col-xs-offset-2 col-xs-5 btn btn-warning">キャンセル</a>
		</div>
	</form>
</div>

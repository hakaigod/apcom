<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学生情報追加
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/addmod.css') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<input type="text" name="strno" class="form-control" placeholder="学籍番号">
		<input type="text" name="strname" class="form-control" placeholder="氏名">
		<!-- 学科 -->
		<select class="form-control select select-primary full" data-toggle="select" name="depnum">
			<?php foreach ($deps as $dep): ?>
				<option value="<?= $dep->depnum; ?>"><?= $dep->depname; ?></option>
			<?php endforeach; ?>
		</select>
		<!-- 学年 -->
		<select class="form-control select select-primary full" data-toggle="select" name="old">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<option value="<?= $i; ?>"><?= $i . "年"; ?></option>
			<?php endfor; ?>
		</select>
		<div class="row">
			<button type="submit" class="col-xs-5 btn btn-success">登録</button>
			<a onclick="window.close()" class="col-xs-offset-2 col-xs-5 btn btn-warning">キャンセル</a>
		</div>
	</form>
</div>

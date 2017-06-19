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
		<!-- 学籍番号 -->
		<input type="text" name="strno" class="form-control" placeholder="学籍番号" value="<?= $regnum->regnum; ?>">
		<!-- 名前 -->
		<input type="text" name="strname" class="form-control" placeholder="氏名" value="<?= $regnum->stuname; ?>">
		<!-- 学科 -->
		<select class="form-control select select-primary full" data-toggle="select" name="depnum">
			<?php foreach ($deps as $dep): ?>
				<option value="<?= $dep->depnum; ?>" <?= $dep->depnum == $regnum->depnum ? "selected" : ""; ?>><?= $dep->depname; ?></option>
			<?php endforeach; ?>
		</select>
		<!-- 学年 -->
		<select class="form-control select select-primary full" data-toggle="select" name="old">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<option value="<?= $i; ?>" <?= $i == $regnum->stuyear ? "selected" : ""; ?>><?= $i . "年"; ?></option>
			<?php endfor; ?>
		</select>

		<div class="row">
			<label class="checkbox col-xs-6">
				削除
				<input type="checkbox" data-toggle="checkbox" name="deleted_flg" <?= $regnum->deleted_flg ? 'checked="checked"' : ""; ?>>
			</label>
			<label class="checkbox col-xs-6">
				卒業
				<input type="checkbox" data-toggle="checkbox" name="graduate_flg" <?= $regnum->graduate_flg ? 'checked="checked"' : ""; ?>>
			</label>
		</div>
		<div class="row">
			<button type="submit" class="col-xs-5 btn btn-success">修正</button>
			<a onclick="window.close()" class="col-xs-offset-2 col-xs-5 btn btn-warning">キャンセル</a>
		</div>
	</form>
</div>

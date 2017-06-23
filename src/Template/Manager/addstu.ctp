<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学生情報追加
<?= $this->end(); ?>
<!-- jsセット -->
<?= $this->start('script'); ?>
	<?= $this->Html->script('/private/js/Manager/upload.js') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<input type="text" name="stuno" class="form-control" placeholder="学籍番号">
		<input type="text" name="stuname" class="form-control" placeholder="氏名">
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
		<div class="full">
			<button type="reset" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>

	<a href="<?= $this->request->webroot ?>private/addstu.csv" class="btn btn-info full" id="download">一括追加用テンプレートダウンロード</a>

	<div class="full" id="upload">
		<form method="post" enctype="" >
			<input type="file" name="studata" size="10">
			<br>
			<button type="submit" class="btn btn-success">送信</button>
		</form>

	</div>


</div>

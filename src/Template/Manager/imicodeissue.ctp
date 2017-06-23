<!-- タイトルセット -->
<?= $this->start('title'); ?>
	模擬試験コード発行画面
<?= $this->end(); ?>

<!-- 以下Content -->
<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post">
		<!-- 学年 -->
		<select class="form-control select select-primary full" data-toggle="select" name="old">
			<?php foreach ($exams as $exam): ?>
				<option value="<?= $exam->exanum; ?>"><?= '平成' . $exam->jap_year . '年' . $exam->exaname;?></option>
			<?php endforeach; ?>
		</select>
		<div class="full">
			<button onclick="window.close()" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

<!-- タイトルセット -->
<?= $this->start('title'); ?>
	学科情報修正
<?= $this->end(); ?>
<?= $this->start('script'); ?>
	<?= $this->Html->script('/private/js/Manager/DepEditCheck.js') ?>
<?= $this->end(); ?>

<div class="container-fluid">
	<div class="center" id="label">
		<label><?= $this->fetch('title')?></label>
	</div>
	<form action="" method="post" id="depManager">
		<!-- 学科番号 -->
		<input type="text" name="depnum" class="form-control" placeholder="学科番号" readonly="readonly" value="<?= $dep->depnum; ?>">
		<!-- 学科名 -->
		<input type="text" name="depname" class="form-control" placeholder="学科名" value="<?= $dep->depname; ?>">

		<div class="full">
			<label class="checkbox">
				削除
				<input type="checkbox" data-toggle="checkbox" name="deleted_flg" <?= $dep->deleted_flg ? 'checked="checked"' : ""; ?>>
			</label>
		</div>
		<div class="full buttons">
			<button type="button" onclick="window.close();" class="col-xs-5 btn btn-warning">キャンセル</button>
			<button type="submit" class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
		</div>
	</form>
</div>

<!-- タイトルセット -->
<?= $this->start('title'); ?>
学科管理
<?= $this->end(); ?>
<!-- ユーザーネームセット -->
<?= $this->start('username'); ?>
managerrrrr
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/depmanager.css') ?>
<?= $this->end(); ?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
	<tr class="info"><td><a href="<?= $this->request->webroot ?>Manager">トップページ</a></td></tr>
	<tr><td><a onclick="window.open('adddep','学生情報追加','width=500,height=400');">学科追加</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<table class="table table-bordered table-hover table-striped" id="deplist">
	<thead>
		<td></td><td>学科番号</td><td>学科名</td><td>削除</td>
	</thead>
	<tbody>
		<?php foreach ($deps as $dep): ?>
			<tr>
				<td class="col-xs-1 center">
					<button class="btn btn-primary" onclick="window.open('moddep?id=<?= $dep->depnum; ?>','学科情報修正','width=500,height=450');">
						修正
					</button>
				</td>
				<td class="col-xs-2"><?= $dep->depnum; ?></td>
				<td class="col-xs-3"><?= $dep->depname; ?></td>
				<td class="col-xs-1"><?= $dep->deleted_flg ? "済" : ""; ?></td>
			</tr>
		<?php  endforeach;?>
	</tbody>
</table>

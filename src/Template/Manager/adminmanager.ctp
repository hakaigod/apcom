<!-- タイトルセット -->
<?= $this->start('title'); ?>
管理者管理
<?= $this->end(); ?>
<!-- ユーザーネームセット -->
<?= $this->start('username'); ?>
managerrrrr
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/adminmanager.css') ?>
<?= $this->end(); ?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
	<tr class="info"><td><a href="">トップページ</a></td></tr>
	<tr><td><a href="" onclick="window.open('addadmin','管理者情報追加','width=500,height=400,scrollbars=yes');">管理者情報追加</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<form action="" method="post">
	<table class="table table-bordered" id="filter">
		<tr>
			<td class="col-xs-3">管理者連番</td>
			<td><input type="text" class="form-control" name="admnum"></td>
		</tr>
		<tr>
			<td class="col-xs-3">名前</td>
			<td><input type="text" class="form-control" name="admname"></td>
		</tr>
		<tr>
			<td class="col-xs-3">削除済み</td>
			<td class="col-xs-3">
				<label class="checkbox">
					<input type="checkbox" data-toggle="checkbox" name="deleted_flg">
				</label>
			</td>
		</tr>
	</table>
	<button type="submit" class="btn btn-primary full" id="search">
		検索実行 <span class="caret"></span>
	</button>
</form>

<table class="table table-bordered table-hover" id="strlist">
	<thead>
		<td></td><td>管理者連番</td><td>氏名</td><td>削除</td>
	</thead>
	<tbody>
		<?php foreach ($admins as $admin): ?>
			<tr>
				<td class="center">
					<a href="" class="btn btn-primary" onclick="window.open('modadmin?id=<?= $admin->admnum; ?>','管理者情報修正','width=500,height=400,scrollbars=yes');">
						修正
					</a>
				</td>
				<td class="col-xs-2"><?= $admin->admnum; ?></td>
				<td class="col-xs-7"><?= $admin->admname; ?></td>
				<td class="col-xs-2"><?= $admin->deleted_flg ? "済" : ""; ?></td>
			</tr>
		<?php  endforeach;?>
	</tbody>
</table>

<!-- タイトルセット -->
<?= $this->start('title'); ?>
学生管理
<?= $this->end(); ?>
<!-- ユーザーネームセット -->
<?= $this->start('username'); ?>
managerrrrr
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/strmanager.css') ?>
<?= $this->end(); ?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
	<tr class="info"><td><a href="">トップページ</a></td></tr>
	<tr><td><a href="" onclick="window.open('addstr','学生情報追加','width=500,height=400,scrollbars=yes');">学生情報追加</a></td></tr>
	<tr><td><a href="" onclick="window.open('modstr','学生情報修正','width=500,height=400,scrollbars=yes');">学生情報修正</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<table class="table table-bordered" id="filter">
	<tr>
		<td class="col-xs-3">学科</td>
		<td class="col-xs-3">
			<select class="form-control select select-primary" data-toggle="select">
				<?php foreach ($deps as $dep): ?>
					<option value="<?= $dep->depnum; ?>"><?= $dep->depname; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
		<td class="col-xs-3">学年</td>
		<td class="col-xs-3">
			<select class="form-control select select-primary" data-toggle="select">
				<?php foreach ($years as $year): ?>
					<option value="<?= $year->stuyear; ?>"><?= $year->stuyear . "年"; ?></option>
				<?php endforeach; ?>
			</select>
		</td>

			</select>
		</td>
	</tr>
	<tr>
		<td class="col-xs-3">学籍番号</td>
		<td colspan="3"><input type="text" class="form-control"></td>
	</tr>
	<tr>
		<td class="col-xs-3">名前</td>
		<td colspan="3"><input type="text" class="form-control"></td>
	</tr>
	<tr>
		<td class="col-xs-3">卒業フラグ</td>
		<td class="col-xs-3">
			<label class="checkbox">
				<input type="checkbox" data-toggle="checkbox">
			</label>
		</td>
		<td class="col-xs-3">合格フラグ</td>
		<td class="col-xs-3">
			<label class="checkbox">
				<input type="checkbox" data-toggle="checkbox">
			</label>
		</td>
	</tr>
</table>
<button class="btn btn-primary full" id="search">
	検索実行
	<span class="caret"></span>
</button>

<table class="table table-bordered table-hover" id="strlist">
	<thead>
		<td></td><td>学籍番号</td><td>氏名</td><td>学科</td><td>学年</td>
	</thead>
	<tbody>
		<?php foreach ($records as $record): ?>
			<tr>
				<td class="col-xs-1">
					<label class="checkbox">
						<input type="checkbox" data-toggle="checkbox">
					</label>
				</td>
				<td class="col-xs-3"><?= $record->regnum; ?></td>
				<td class="col-xs-3"><?= $record->stuname; ?></td>
				<td class="col-xs-4"><?= $record->mf_dep['depname']; ?></td>
				<td class="col-xs-1"><?= $record->stuyear . "年"; ?></td>
			</tr>
		<?php  endforeach;?>
	</tbody>
</table>

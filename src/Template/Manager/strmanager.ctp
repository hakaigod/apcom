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
	<tr class="info"><td><a href="<?= $this->request->webroot ?>Manager">トップページ</a></td></tr>
	<tr><td><a href="">学生情報閲覧</a></td></tr>
	<tr><td><a onclick="window.open('addstr','学生情報追加','width=500,height=400,scrollbars=yes');">学生情報追加</a></td></tr>
	<tr><td><a onclick="window.open('reissuestupass','学生パスワード再発行','width=500,height=400');">学生パスワード再発行</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<form action="" method="post">
	<table class="table table-bordered" id="filter">
		<tr>
			<td class="col-xs-3">学籍番号</td>
			<td colspan="3"><input type="text" class="form-control" name="regnum" value="<?= empty(@$_POST['regnum']) ? '' : $_POST['regnum']; ?>"></td>
		</tr>
		<tr>
			<td class="col-xs-3">名前</td>
			<td colspan="3"><input type="text" class="form-control" name="stuname" value="<?= empty(@$_POST['stuname']) ? '' : $_POST['stuname']; ?>"></td>
		</tr>
		<tr>
			<td class="col-xs-3">学科</td>
			<td class="col-xs-3">
				<select class="form-control select select-primary full" data-toggle="select" name="depnum">
					<option value="0">全学科</option>
					<?php foreach ($deps as $dep): ?>
						<option value="<?= $dep->depnum; ?>" <?= @$_POST['depnum'] == $dep->depnum ? 'selected' : ''; ?>><?= $dep->depname; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td class="col-xs-3">学年</td>
			<td class="col-xs-3">
				<select class="form-control select select-primary full" data-toggle="select" name="stuyear">
					<option value="0">全学年</option>
					<?php for ($i=1; $i <= 3; $i++): ?>
						<option value="<?= $i; ?>" <?= @$_POST['stuyear'] == $i ? 'selected' : ''; ?>><?= $i . "年"; ?></option>
					<?php endfor; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">卒業フラグ含む</td>
			<td class="col-xs-3">
				<label class="checkbox">
					<input type="checkbox" data-toggle="checkbox" name="graduate_flg"<?= empty(@$_POST['graduate_flg']) ? '' : 'checked="checked"'; ?>>
				</label>
			</td>
			<td class="col-xs-3">削除済み含む</td>
			<td class="col-xs-3">
				<label class="checkbox">
					<input type="checkbox" data-toggle="checkbox" name="deleted_flg"<?= empty(@$_POST['deleted_flg']) ? '' : 'checked="checked"'; ?>>
				</label>
			</td>
		</tr>
	</table>
	<button type="submit" class="btn btn-primary full" id="search">
		検索実行 <span class="caret"></span>
	</button>
</form>

<table class="table table-bordered table-hover table-striped" id="strlist">
	<thead>
		<td></td><td>学籍番号</td><td>名前</td><td>学科</td><td>学年</td><td>卒業</td><td>削除</td>
	</thead>
	<tbody>
		<?php foreach ($records as $record): ?>
			<tr>
				<td class="col-xs-1 center">
					<button class="btn btn-primary" onclick="window.open('modstr?id=<?= $record->regnum; ?>','学生情報修正','width=500,height=450');">
						修正
					</button>
				</td>
				<td class="col-xs-2"><?= $record->regnum; ?></td>
				<td class="col-xs-3"><?= $record->stuname; ?></td>
				<td class="col-xs-3"><?= $record->mf_dep['depname']; ?></td>
				<td class="col-xs-1"><?= $record->stuyear . "年"; ?></td>
				<td class="col-xs-1"><?= $record->graduate_flg ? "済" : "";; ?></td>
				<td class="col-xs-1"><?= $record->deleted_flg ? "済" : ""; ?></td>
			</tr>
		<?php  endforeach;?>
	</tbody>
</table>

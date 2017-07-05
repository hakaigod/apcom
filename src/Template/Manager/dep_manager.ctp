<!-- タイトルセット -->
<?= $this->start('title'); ?>
学科管理
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/depmanager.css') ?>
<?= $this->end(); ?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
	<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
	<tr><td><a onclick="window.open('<?=$this->Url->build(["action" => "adddep"])?>','学科情報追加','width=500,height=400');">学科追加</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<form action="" method="post">
	<table class="table table-bordered" id="filter">
		<tr>
			<td class="col-xs-3">学科連番</td>
			<td><input type="text" class="form-control" name="depnum" value="<?= empty(@$_POST['depnum']) ? '' : $_POST['depnum']; ?>"></td>
		</tr>
		<tr>
			<td class="col-xs-3">名前</td>
			<td><input type="text" class="form-control" name="depname" value="<?= empty(@$_POST['depname']) ? '' : $_POST['depname']; ?>"></td>
		</tr>
		<tr>
			<td class="col-xs-3">削除済み含む</td>
			<td class="col-xs-3">
				<label class="checkbox">
					<input type="checkbox" data-toggle="checkbox" name="deleted_flg" <?= empty(@$_POST['deleted_flg']) ? '' : 'checked="checked"'; ?>>
				</label>
			</td>
		</tr>
	</table>
	<div class="row">
		<div class="col-xs-3">
			<a href="" class="btn btn-warning full">クリア</a>
		</div>
		<div class="col-xs-offset-4 col-xs-5">
			<button type="submit" class="btn btn-primary full" id="search">
				検索実行 <span class="fui-arrow-right"></span>
			</button>
		</div>
	</div>
</form>

<table class="table table-bordered table-hover table-striped" id="deplist">
	<thead>
		<td>学科番号</td><td>学科名</td><td>削除</td><td></td>
	</thead>
	<tbody>
		<?php foreach ($deps as $dep): ?>
			<tr>
				<td class="col-xs-2"><?= $dep->depnum; ?></td>
				<td class="col-xs-8"><?= $dep->depname; ?></td>
				<td class="col-xs-1"><?= $dep->deleted_flg ? "済" : ""; ?></td>
				<td class="col-xs-1 center">
					<button class="btn btn-primary" onclick="window.open('moddep?id=<?= $dep->depnum; ?>','学科情報修正','width=500,height=450');">
						修正
					</button>
				</td>
			</tr>
		<?php  endforeach;?>
	</tbody>
</table>

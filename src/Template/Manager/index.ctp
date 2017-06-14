<!-- タイトルセット -->
<?= $this->start('title'); ?>
	管理者メニュー
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Manager/index.css') ?>
<?= $this->end(); ?>

<!-- jsセット -->
<?= $this->start('script'); ?>
	<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?= $this->end(); ?>

<!-- ユーザーネームセット -->
<?= $this->start('username'); ?>
	managerrrrr
<?= $this->end(); ?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
	<tr class="info"><td><a href="<?= $this->request->webroot ?>Manager">トップページ</a></td></tr>
	<tr><td><a href="Manager/strmanager">学生情報管理</a></td></tr>
	<tr><td><a href="#">管理者管理</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<table class="table table-bordered" id="filter">
	<tr>
		<td class="col-xs-3">年度</td>
		<td class="col-xs-3">
			<select class="form-control select select-primary full" data-toggle="select">
				<option value="0">平成23年春</option>
				<option value="1">平成23年秋</option>
			</select>
		</td>
		<td class="col-xs-3">学年</td>
		<td class="col-xs-3">
			<select class="form-control select select-primary full" data-toggle="select">
				<option value="0">1年</option>
				<option value="1">2年</option>
				<option value="1">3年</option>
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
</table>
<button class="btn btn-primary full" id="search">
	検索実行
	<span class="caret"></span>
</button>

<h5 id="AMresulttitle">午前結果表示</h5>
<div class="row">
	<div class="col-xs-6" id="AMresult">
		<table class="table table-bordered full">
			<thead>
				<tr>
					<td>学籍番号</td><td>名前</td><td>合計</td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $i < 20 ; $i++): ?>
					<tr>
						<td>15110004</td><td>一二三　一二三</td><td>10</td>
					</tr>
				<?php endfor; ?>
				<tr>
					<td colspan="2">平均</td><td>平均</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-xs-6" id="questions">
		<table class="table table-bordered center" >
			<thead>
				<tr>
					<?php for($i = 1; $i <= 10 ;$i++): ?>
						<td><?= $i; ?></td>
					<?php endfor;?>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $i < 20 ; $i++): ?>
					<tr>
						<?php for($j = 1; $j <= 10 ;$j++): ?>
							<td>イ</td>
						<?php endfor;?>
					</tr>
				<?php endfor; ?>
				<tr>
					<?php for($j = 1; $j <= 10 ;$j++): ?>
						<td>平均</td>
					<?php endfor;?>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<?php for ($qno=1; $qno <= 10; $qno++): ?>
		<div class="col-xs-3">
			<div class="qno">問 <?= $qno ?></div>
			<div>問題文</div>
			<div class="font"><b class="oooo">50</b>%</div>
		</div>
	<?php endfor; ?>
</div>

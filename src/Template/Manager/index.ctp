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
	<tr class="info"><td><a href="">トップページ</a></td></tr>
	<tr><td><a href="Manager/strmanager">学生情報管理</a></td></tr>
	<tr><td><a href="Manager/adminmanager">管理者管理</a></td></tr>
	<tr><td><a href="Manager" onclick="window.open('Manager/imicodeissue','模擬試験コード発行','width=500,height=400');">模擬試験コード発行</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<h5 id="AMresulttitle">直近一回分試験結果</h5>
※空白は回答なし
<div class="row">
	<div class="col-xs-6" id="AMresult">
		<table class="table table-bordered full">
			<thead>
				<tr>
					<td class="col-xs-9">名前</td><td class="col-xs-3">合計</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($students as $student): ?>
					<tr>
						<td><?= $student->mf_stu['stuname']; ?></td>
						<td><?= $student->imisum . '点'; ?></td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="">平均</td><td><?= number_format($average['average'],2) . '点'; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-xs-6" id="questions">
		<table class="table table-bordered center" >
			<thead>
				<tr>
					<?php for($i = 1; $i <= 80 ;$i++): ?>
						<td><?= "問" . $i; ?></td>
					<?php endfor;?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($answers as $answer): ?>
					<tr>
						<?php foreach ($answer as $ans): ?>
							<td><?= $ans; ?></td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				<tr>
					<?php for($j = 1; $j <= 80 ;$j++): ?>
						<td>平均</td>
					<?php endfor;?>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<?php for ($qno=1; $qno <= 10; $qno++): ?>
		<div class="col-par-5">
			<div class="qno">問 <?= $qno ?></div>
			<div>問題文</div>
			<div class="font"><b class="oooo">50</b>%</div>
		</div>
	<?php endfor; ?>
</div>
<div class="row">
	<table class="table table-bordered">
		<thead>
			<tr>
				<td class="col-xs-6">試験名</td><td class="col-xs-3">受験者数</td><td class="col-xs-3">平均点</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($imidata as $key => $value): ?>
				<tr>
					<td><?= $value['name'] . ' ' .$value['num'] . '回目';?></td>
					<td><?= $value['imipepnum'] == null ? '受験者なし' : $value['imipepnum'] . '人';?></td>
					<td><?= $value['imipepnum'] == null ? '受験者なし' : number_format($value['imisum'] / $value['imipepnum'], 2);?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

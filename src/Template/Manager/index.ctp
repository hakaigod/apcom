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
	<?= $this->Html->script('/private/js/Manager/autoload.js') ?>
<?= $this->end(); ?>

<!-- ユーザーネームセット -->
<?= $this->start('username'); ?>
	managerrrrr
<?= $this->end(); ?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
	<tr class="info"><td><a href="">トップページ</a></td></tr>
	<tr><td><a href="Manager/StuManager">学生情報管理</a></td></tr>
	<tr><td><a href="Manager/depManager">学科管理</a></td></tr>
	<tr><td><a href="Manager/adminManager">管理者管理</a></td></tr>
	<tr><td><a onclick="window.open('Manager/imicodeissue','模擬試験コード発行','width=500,height=400');">模擬試験コード発行</a></td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<h5 id="answerstitle"><?= $detaiExamName; ?>試験結果</h5>
<div class="row" id="answershead">
	<div class="col-xs-6">
		※空白は回答なし
	</div>
	<div class="col-xs-6 right">
		<div class="bootstrap-switch-square">
			10秒更新
			<input type="checkbox" data-toggle="switch" id="load_switch" value="load_switch" <?= !empty($_GET['autoload']) ? 'checked' : '';?>/>
		</div>
	</div>
</div>
<div id="answers">
	<div id="AMresult">
		<table class="table table-bordered table-striped full">
			<thead>
				<tr>
					<td class="col-xs-3" id="name">名前</td><td class="stusum">合計</td>
					<?php foreach ($questions as $key): ?>
						<td id="ques"><?= "問" . $key['qesnum']; ?></td>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($answers as $answer => $value): ?>
					<tr>
						<td>100.00点</td>
						<td><?= number_format($value['imisum'] * 1.25, 2) . '点'; ?></td>
						<?php foreach ($value['answers'] as $ans): ?>
							<td class="center"><?= $ans; ?></td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td>平均</td>
					<td><?= $average != 0 ? number_format($average * 1.25 ,2) . '点' : 0 . '点'; ?></td>
					<?php foreach ($questionsdetail as $par): ?>
						<td>
							<?= number_format($par['corrects'] * 100, 0) . '%'; ?>
						</td>
					<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- ページネーター -->
	<div class="center">
		<?= $this->Paginator->counter(['format' => '{{page}} / {{pages}}']); ?>
		<ul class="pagination-plain">
			<!-- 最初,前へ　ボタン設置 -->
			<?= $this->Paginator->first('<<'); ?>
			<?= $this->Paginator->prev('<') ?>
			<!-- 途中ページ　ボタン設置 -->
			<?= $this->Paginator->numbers(); ?>
			<!-- 次へ,最後　ボタン設置 -->
			<?= $this->Paginator->next('>') ?>
			<?= $this->Paginator->last('>>'); ?>
		</ul>
	</div>
</div>
<div class="row" id="correctRate">
	<div class="col-xs-12">
		<h6>正答率</h6>
		<?php $i = 0; foreach ($questionsdetail as $key): ?>
			<div class="col-par-5" id="<?= 'q' . $i?>">
				<div class="qno"><a onclick="window.open('Manager/QuestionDetail?ex=<?= $key['exanum'] . '&qn='. $key['qesnum'];?>','問題詳細','width=700,height=400,scrollbars=yes');">問 <?= $key['qesnum']; ?></a></div>
				<div id="question"><?= mb_strimwidth(strip_tags($key['question']), 0, 40, "..."); ?></div>
				<div class="par"><b class="parnum"><?= number_format($key['corrects'] * 100, 1); ?></b>%</div>
			</div>
		<?php $i++;endforeach; ?>
	</div>
</div>

<div class="row">
	<div class="col-xs-12" id="examdata">
		<h5>過去試験データ</h5>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<td class="col-xs-2">回数</td><td class="col-xs-4">試験名</td><td class="col-xs-3">受験者数</td><td class="col-xs-3">平均点</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($imidata as $key => $value): ?>
					<tr>
						<td><?= $value['imi'];?></td>
						<td><a href="?id=<?= $value['imi']; ?>"><?= $value['name'] . ' ' .$value['num'] . '回目';?></a></td>
						<td><?= $value['imipepnum'] == null ? '受験者なし' : $value['imipepnum'] . '人';?></td>
						<td><?= $value['imipepnum'] == null ? '受験者なし' : number_format($value['imisum'] / $value['imipepnum'] * 1.25, 2) . '点';?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<!-- タイトルセット -->
<?= $this->start('title'); ?>
	問題詳細
<?= $this->end(); ?>

<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/ap.css') ?>
	<?= $this->Html->css('/private/css/Manager/questionDetail.css') ?>
<?= $this->end(); ?>
<?= $this->start('script'); ?>
	<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js') ?>
<?= $this->end(); ?>

<!-- 以下Content -->

<!-- 問題が出題された年度と問題番号 -->
<h4><?= $questionDetail->mf_exa->exam_detail . '　問' . $questionDetail->qesnum; ?></h4>
<!-- 問題文 -->
<!-- 問題画像があれば表示される -->
<div class="row" id="question">
	<?= $this->qaa->viewTextImg($questionDetail->question)?>
</div>

<?php if(empty($questionDetail->answer_pic)): ?>
	<!-- 選択肢が画像ではない場合 -->
	<div class="row" id="choice">
		<table class="table table-bordered">
			<tbody>
				<tr>
					<td class="col-xs-1">ア</td>
					<td><?= $this->qaa->viewTextImg($questionDetail->choice1)?></td>
				</tr>
				<tr>
					<td class="col-xs-1">イ</td>
					<td><?= $this->qaa->viewTextImg($questionDetail->choice2)?></td>
				</tr>
				<tr>
					<td class="col-xs-1">ウ</td>
					<td><?= $this->qaa->viewTextImg($questionDetail->choice3)?></td>
				</tr>
				<tr>
					<td class="col-xs-1">エ</td>
					<td><?= $this->qaa->viewTextImg($questionDetail->choice4)?></td>
				</tr>
			</tbody>
		</table>
	</div>
<?php else:?>
	<!-- 選択肢が画像の場合 -->
	<div class="row" id="choice">
		<div class="center">
			<?= $this->qaa->viewTextImg($questionDetail->answer_pic)?>
		</div>
	</div>
<?php endif;?>

<div class="row">
<p>正解 :
	<?php switch ($selectAnswer['correct']) {
		case 1: echo "ア"; break;
		case 2: echo "イ"; break;
		case 3: echo "ウ"; break;
		default: echo "エ"; break;
	}?>
</p>
</div>

<!-- 各選択肢の選択率 -->
<div class="row">
	<canvas id="myChart" height="50"></canvas>
	<script type="text/javascript">
		var selectAnswer = [<?= $selectAnswer[1]?>, <?= $selectAnswer[2]?>,<?= $selectAnswer[3]?>,<?= $selectAnswer[4]?>];
		var correct_answer = <?= $selectAnswer['correct'] - 1 ?>;
	</script>
	<script type="text/javascript" src="<?= $this->request->getAttribute('webroot')?>/private/js/Manager/selectAnswerRate.js"></script>
</div>


<div class="row buttons">
	<div class="col-xs-3">
		<?php if ($qn != 1): ?>
			<a href="<?= '?ex=' . $ex . '&qn=' . ($qn - 1);?>" class="btn btn-primary full">
				前の問題
			</a>
		<?php endif;?>
	</div>
	<div class="col-xs-6">
		<button type="button" onclick="window.close();" class="btn btn-warning full">閉じる</button>
	</div>
	<div class="col-xs-3">
		<?php if ($qn != 80): ?>
			<a href="<?= '?ex=' . $ex . '&qn=' . ($qn + 1);?>" class="btn btn-primary full">
				次の問題
			</a>
		<?php endif;?>
	</div>
</div>

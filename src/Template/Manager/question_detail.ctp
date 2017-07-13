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
<?php
	function json_safe_encode($data){
	    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
	}
?>

<!-- 以下Content -->

<!-- 問題が出題された年度と問題番号 -->
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4><?= $questionDetail->mf_exa->exam_detail . '　問' . $questionDetail->qesnum; ?></h4>
</div>
<div class="modal-body">
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

		<script type="text/javascript" id="script"
			src="<?= $this->request->getAttribute('webroot')?>/private/js/Manager/selectAnswerRate.js"
			data-select = '<?= json_safe_encode($selectAnswer['answers']); ?>'
			data-correct = '<?= json_safe_encode($selectAnswer['correct']); ?>'
		></script>
	</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

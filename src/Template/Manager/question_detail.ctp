<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/ap.css') ?>
<?= $this->end(); ?>

<!-- 問題が出題された年度と問題番号 -->
<h4><?= '平成' . $questionDetail->mf_exa->jap_year . '年' . $questionDetail->mf_exa->exaname . '　問' . $questionDetail->qesnum; ?></h4>
<!-- 問題文 -->
<div><?= $questionDetail->question; ?></div>
<!-- 問題画像があれば表示される -->
<?= strip_tags($questionDetail->answer_pic); ?>

<?php if(empty($questionDetail->answer_pic)): ?>
	<!-- 選択肢が画像ではない場合 -->
	<table class="table table-bordered">
		<tbody>
			<tr>
				<td class="col-xs-1">ア</td><td><?= $questionDetail->choice1; ?></td>
			</tr>
			<tr>
				<td class="col-xs-1">イ</td><td><?= $questionDetail->choice2; ?></td>
			</tr>
			<tr>
				<td class="col-xs-1">ウ</td><td><?= $questionDetail->choice3; ?></td>
			</tr>
			<tr>
				<td class="col-xs-1">エ</td><td><?= $questionDetail->choice4; ?></td>
			</tr>
		</tbody>
	</table>
<?php else:?>
	<!-- 選択肢が画像の場合 -->
	<?= strip_tags($questionDetail->answer_pic); ?>
<?php endif;?>
<div class="full buttons">
	<button type="button" onclick="window.close();" class="col-xs-12 btn btn-warning">閉じる</button>
</div>

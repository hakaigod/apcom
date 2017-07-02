<?php
/**
 *
 * @var \App\View\AppView $this
 *
 * 試験名
 * @var string $exaname
 * 問題文、正答
 * @var \App\Model\Entity\MfQe[] $questions
 * 生徒が選んだ解答
 * @var \App\Model\Entity\TfAn[] $answers
 * 生徒の点数
 * @var int $score
 * 問題ごとの正答率
 * @var array $correctRates
 * 試験の平均点
 * @var float $average
 * 生徒の順位
 * @var int $rank
 */
?>

<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<?php $this->end(); ?>

<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request-> getAttribute('webroot') . "/Manager" ?>">トップページ</a></td></tr>
<?php $this->end(); ?>
<?php if( !(isset($year))|| !(isset($season)) || !(isset($implNum)) || !(isset($average))):?>
    <br><br>
    <div class="alert alert-danger" role="alert">
        この模擬試験は実施されていません
    </div>
<?php else:?>
    <h3><?= $exaname?></h3>
    <h4>平均点:<?= round($average,1) ?>点</h4>
    
	<?php if(empty($answers) || empty($correctRates)): ?>
        <div class="alert alert-warning" role="alert">
            まだ入力されていません
        </div>
	<?php else:?>
        <h4>合計点:<?= $score ?>点</h4>
        <h4>順位:<?= $rank ?></h4>
		<?php
		$answersStr = ['未','ア','イ','ウ','エ'];
		$confidenceStr = ['未','○','△','×'];
		?>
        <table class="table table-bordered table-striped table-hover">
			<?= $this->Html->tableHeaders(['番号','問題文','解答', '正答','自信度','○×','正答率'],[],['class' => 'center']); ?>
            <tbody>
			<?php foreach (range(1, 80) as $i ): ?>
                <tr>
                    <th class="col-xs-1 center">
						<?= $i?>
                    </th>
                    <!--                問題文(最初の10文字のみ)-->
                    <td class="col-xs-5">
						<?= mb_substr(strip_tags($questions[ $i - 1 ]->question), 0, 17) ?>
                        ...
                    </td>
                    <td class="col-xs-1 center">
						<?= $answersStr[$answers[$i - 1]->rejoinder] ?>
                    </td>
                    <td class="col-xs-1 center">
						<?= $answersStr[$answers[$i - 1]->correct_answer] ?>
                    </td>
                    <td class="col-xs-1 center">
						<?=  $confidenceStr[$answers[$i - 1]->confidence] ?>
                    </td>
                    <td class="col-xs-1 center">
						<?php
						if ($answers[$i - 1]->rejoinder == $answers[$i - 1]->correct_answer) {
							echo "○";
						}else{
							echo "×";
						}
						?>
                    </td>
                    <td class="col-xs-2 center">
						<?= round($correctRates[$i - 1] * 100,1) ?>%
                    </td>
                </tr>
			<?php endforeach;?>
            </tbody>
        </table>
	<?php endif; ?>
<?php endif; ?>
<br><br><br><br>
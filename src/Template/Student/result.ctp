<?php
/**
 *
 * @var \App\View\AppView $this
 *
 * @var int $year
 * @var string $season
 * @var int $implNum
 * @var float $average
 * @var \App\Model\Entity\MfQe[] $questions
 * @var \App\Model\Entity\TfAn[] $answers
 * @var \App\Model\Entity\TfSum $score
 */
?>

<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<?php $this->end(); ?>

<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request-> getAttribute('webroot') ?>/Manager">トップページ</a></td></tr>
<tr><td><a href="manager/strmanager">学生情報管理</a></td></tr>
<?php $this->end(); ?>

<h3><?= "平成{$year}年{$season} {$implNum}回目"?></h3>
<h4>平均点:<?= $average ?>点</h4>
<h4>合計点:<?= $score?$score->imisum:0 ?>点</h4>
<?php
//TODO:平均点を表示する！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！
$answersStr = ['未','ア','イ','ウ','エ'];
$confidenceStr = ['未','○','△','×'];
?>
<?php if(empty($answers)): ?>
    まだ入力されていません
<?php else:?>
    <table class="table table-bordered table-striped table-hover">
		<?= $this->Html->tableHeaders(['番号','問題文','解答', '正答','自信度','○×'],[],['class' => 'center']); ?>
		<?php foreach (range(1, 80) as $i ): ?>
            <tr>
                <td class="col-xs-1 center">
					<?= $i?>
                </td>
                <!--                問題文(最初の10文字のみ)-->
                <td class="col-xs-3">
					<?= mb_substr(strip_tags($questions[ $i - 1 ]->question), 0, 10) ?>
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
            </tr>
		<?php endforeach;?>
    </table>
<?php endif; ?>
<br><br><br><br>
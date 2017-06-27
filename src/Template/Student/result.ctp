<?php
/**
 *
 * @var \App\View\AppView $this
 * @var int $year
 * @var string $season
 * @var \App\Model\Entity\MfQe[] $questions
 * @var \App\Model\Entity\TfAn[] $answers
 *
 *
 */
?>

<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<?php $this->end(); ?>

<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request-> getAttribute('webroot') ?>/Manager">トップページ</a></td></tr>
<tr><td><a href="manager/strmanager">学生情報管理</a></td></tr>
<?php $this->end(); ?>

<h3><?= '平成' . ($year) . '年 ' . $season?></h3>

<?php
//TODO:何回目、合計、平均点を表示する！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！！
$answersStr = ['未','ア','イ','ウ','エ'];
$confidenceStr = ['未','○','△','×'];
?>

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
                <?= $ans = $answersStr[$answers[$i - 1]->rejoinder] ?>
            </td>
            <td class="col-xs-1 center">
		        <?= $correctAns = $answersStr[$answers[$i - 1]->correct_answer] ?>
            </td>
            <td class="col-xs-1 center">
		        <?= $conf = $confidenceStr[$answers[$i - 1]->confidence] ?>
            </td>
            <td class="col-xs-1 center">
		        <?php
                if ($ans == $correctAns) {
                    echo "○";
                }else{
                    echo "×";
                }
                ?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<br><br><br><br>
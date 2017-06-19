<?= $this->start('css'); ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<?= $this->end(); ?>

<?= $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request->webroot ?>/Manager">トップページ</a></td></tr>
<tr><td><a href="manager/strmanager">学生情報管理</a></td></tr>
<tr><td><a href="#">管理者管理</a></td></tr>
<?= $this->end(); ?>

<h3><?= '平成' . ($year) . '年 ' . $season?></h3>
<form action="" method="post">
    <table class="table table-bordered table-striped table-hover">
		<?= $this->Html->tableHeaders(['番号','問題文', '解答','自信度'],[],['class' => 'center']); ?>
		<?php foreach (range(1, 10) as $i ): ?>
            <tr>
                <td class="col-xs-1 center">
					<?= $questions[ $i - 1 ]['qesnum'] ?>
                </td>
                <td class="col-xs-3">
					<?= mb_substr(strip_tags($questions[ $i - 1 ]['question']), 0, 10) ?>
                    ...
                </td>
                <td class="col-xs-5 center">
                    <div data-toggle="buttons">
                        <label class="btn btn-info">
                            <input type="radio" name="<?= $answerTag ="answer_{$i}" ?>" autocomplete="off" value="1"> ア
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="<?= $answerTag ?>" autocomplete="off" value="2"> イ
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="<?= $answerTag ?>" autocomplete="off" value="3"> ウ
                        </label>
                        <label class="btn btn-info">
                            <input type="radio"  name="<?= $answerTag ?>" autocomplete="off" value="4"> エ
                        </label>
                        <label class="btn btn-info active">
                            <input type="radio"  name="<?= $answerTag ?>" autocomplete="off" checked value="0"> 未記入
                        </label>
                    </div>
                </td>
                <td class="col-xs-3 center">
                    <div data-toggle="buttons">
                        <label class="btn btn-info">
                            <input type="radio" name="<?= $confTag = "confidence_{$i}" ?>" autocomplete="off" value="1"> o
                        </label>
                        <label class="btn btn-info active">
                            <input type="radio" name="<?= $confTag ?>" autocomplete="off" checked value="2"> △
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="<?= $confTag ?>" autocomplete="off" value="3"> x
                        </label>
                    </div>
                </td>
            </tr>
		<?php endforeach; ?>
    </table>
    <br>
	<div class="center">
	<?php
	foreach (range(1, 8) as $buttonNum ) {
		$btnClass =  "btn btn-info ";
		//現在のページのボタンの色を濃くする
		if ( $buttonNum == $curNum ) {
			$btnClass .= "active";
		}
		//formactionは遷移先
		echo "<button type='submit' name='buttonNum' value='{$buttonNum}' formaction= '{$buttonNum}' class='{$btnClass}'>";
		echo "{$buttonNum}</button>";
//    echo $this->Html->link( $linkNum, ['action' => 'input', $season , $linkNum],["class" => $btnClass]);
	}
	?>
    </div>
</form>

<br><br><br><br><br><br><br><br>
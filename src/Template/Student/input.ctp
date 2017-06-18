<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
<?= $this->Html->script('video.js') ?>
<?= $this->Html->script('flat-ui.min.js') ?>

<?= $this->Html->css('bootstrap.min.css') ?>
<?= $this->Html->css('flat-ui.css') ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<h3><?= '平成' . ($year) . '年 ' . $season?></h3>
<form action="" method="post">
    <table class="table table-bordered table-striped table-hover">
		<?= $this->Html->tableHeaders(['問題番号', '解答','自信度']); ?>
		<?php foreach (range(1, 10) as $i ): ?>
            <tr>
                <td><?= ($curNum - 1) * 10 + $i ?></td>
                <td>
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
                <td>
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
</form>

<br><br><br><br><br><br><br><br>
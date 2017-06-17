<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
<?= $this->Html->script('video.js') ?>
<?= $this->Html->script('flat-ui.min.js') ?>

<?= $this->Html->css('bootstrap.min.css') ?>
<?= $this->Html->css('flat-ui.css') ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>

<form action="" method="post">
    <table class="table table-bordered table-striped table-hover">
		<?= $this->Html->tableHeaders(['問題番号', '解答','自信度']); ?>
		<?php foreach (range(1, 10) as $i ): ?>
            <tr>
                <td><?= $i ?></td>
                <td>
                    <div data-toggle="buttons">
                        <label class="btn btn-info">
                            <input type="radio" name="<?= "answer_" . ($i - 1) ?>" autocomplete="off" value="1"> ア
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="<?= "answer_" . ($i - 1) ?>" autocomplete="off" value="2"> イ
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="<?= "answer_" . ($i - 1) ?>" autocomplete="off" value="3"> ウ
                        </label>
                        <label class="btn btn-info">
                            <input type="radio"  name="<?= "answer_" . ($i - 1) ?>" autocomplete="off" value="4"> エ
                        </label>
                        <label class="btn btn-info active">
                            <input type="radio"  name="<?= "answer_" . ($i - 1) ?>" autocomplete="off" checked value="0"> 未記入
                        </label>
                    </div>
                </td>
                <td>
                    <div data-toggle="buttons">
                        <label class="btn btn-info">
                            <input type="radio" name="<?= "confidence_" . ($i - 1) ?>" autocomplete="off" value="1"> o
                        </label>
                        <label class="btn btn-info active">
                            <input type="radio" name="<?= "confidence_" . ($i - 1) ?>" autocomplete="off" checked value="2"> △
                        </label>
                        <label class="btn btn-info">
                            <input type="radio" name="<?= "confidence_" . ($i - 1) ?>" autocomplete="off" value="3"> x
                        </label>
                    </div>
                </td>
            </tr>
		<?php endforeach; ?>
    </table>
    <button type="submit" class="btn btn-success">登録</button>
</form>
<br>
<?php
foreach (range(1, 8) as $linkNum ) {
    $btnClass =  "btn btn-info ";
    if ( $linkNum == $qnum ) {
        $btnClass .= "active";
    }
    echo $this->Html->link( $linkNum, ['action' => 'input', $season , $linkNum],["class" => $btnClass]);
}
?>

<br><br><br><br><br><br><br><br>
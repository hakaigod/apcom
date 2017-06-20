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
					<?= $qNum = $questions[ $i - 1 ]['qesnum'] ?>
                </td>
                <td class="col-xs-3">
					<?= mb_substr(strip_tags($questions[ $i - 1 ]['question']), 0, 10) ?>
                    ...
                </td>
                <td class="col-xs-5 center">
                    <div data-toggle="buttons">
	                    <?php
	                    $ansChoices = ['ア','イ','ウ','エ','未記入'];
                        $answerTag = 'answer_' . $qNum;
                        //前回入力されていた答え
	                    $inputtedAns = $inputtedLog['answers'][$qNum];
	                    for($x = 0; $x < sizeof($ansChoices); $x++ ) {
	                        //未入力は0にするため
		                    $value = ($x + 1) % sizeof($ansChoices);
		                    //もし選択されていたら見た目に反映するためクラスを変更する
		                    if ($inputtedAns == $value) {
		                        $active = 'active ';
		                        $checked = 'checked ';
                            }else{
		                        $active = $checked ="";
                            }
                            
	                        echo "<label class=\"btn btn-info {$active}\">";
		                    echo "<input type=\"radio\" name=\"{$answerTag}\" "
                                .$checked ."autocomplete=\"off\" value=\"{$value}\">"
                                . $ansChoices[$x];
		                    echo '</label>';
	                    }
	                    ?>
                    </div>
                </td>
                <td class="col-xs-3 center">
                    <div data-toggle="buttons">
                        <?php
                        $confChoices = ['o','△','X'];
                        $inputtedConf = $inputtedLog['confidences'][$qNum];
                        //前回入力されていた自信度
                        $confTag = "confidence_{$qNum}";
                        //1,2,3
                        foreach ( range(1,sizeof($confChoices)) as $y ) {
                            if ($y == $inputtedConf) {
                                $checked = 'checked';
                                $active = 'active';
                            }else{
                                $checked = '';
                                $active = '';
                            }
	                        echo "<label class=\"btn btn-info {$active}\" >";
                            echo "<input type=\"radio\" name=\"{$confTag}\" "
                            ."autocomplete=\"off\" {$checked} value=\"{$y}\">";
                            echo $confChoices[$y - 1];
	                        echo '</label>';
                        }
                        
                        ?>
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
		echo "<button type='submit' name='curNum' value='{$curNum}' formaction= '{$buttonNum}' class='{$btnClass}'>";
		echo "{$buttonNum}</button>";
//    echo $this->Html->link( $linkNum, ['action' => 'input', $season , $linkNum],["class" => $btnClass]);
	}
	?>
    </div>
</form>

<br><br><br><br><br><br><br><br>
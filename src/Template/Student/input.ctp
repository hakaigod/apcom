<?php
/**
 * [模擬試験結果(各解答)の入力ページ]
 *
 * @var \App\View\AppView $this
 * この模擬試験の基が行われた年
 * @var Integer $year
 * この模擬試験の基が行われた季節
 * @var String $season
 * DBから取得した問題一覧
 * @var \App\Model\Entity\MfQe[][] $questions
 * 過去に入力されていた解答と自信度
 * @var array $inputtedLog
 * 現在表示しているページ番号 currentNum
 * @var Integer $curNum
 * @var bool $isAnsed
 * @var bool[] $notAnsedPages
 *
 */
?>
<?php
function json_safe_encode($data){
	return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>

<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<?php $this->end(); ?>

<?php $this->start('script'); ?>
<!--http://qiita.com/cither/items/b98cc4e237dcc8f7e51f-->
<script id="script" src="<?= $this->request-> getAttribute('webroot') ?>/private/js/Input/input.js"
        isAnsed = <?= json_safe_encode($isAnsed)?>
        curNum = <?= json_safe_encode($curNum)?>
></script>
<?php $this->end(); ?>


<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request-> getAttribute('webroot') ?>/Manager">トップページ</a></td></tr>
<tr><td><a href="manager/strmanager">学生情報管理</a></td></tr>
<tr><td><a href="#">管理者管理</a></td></tr>
<?php $this->end(); ?>

<h3><?= '平成' . ($year) . '年 ' . $season?></h3>
<form action="" method="post" id="answer-form">
    <table class="table table-bordered table-striped table-hover">
		<?= $this->Html->tableHeaders(['番号','問題文', '解答','自信度'],[],['class' => 'center']); ?>
		<?php foreach (range(1, 10) as $i ): ?>
            <tr>
                <!--                問題番号-->
                <td class="col-xs-1 center">
					<?= $qNum = $questions[ $i - 1 ]['qesnum'] ?>
                </td>
                <!--                問題文(最初の10文字のみ)-->
                <td class="col-xs-3">
					<?= mb_substr(strip_tags($questions[ $i - 1 ]['question']), 0, 10) ?>
                    ...
                </td>
                <!--                解答-->
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
							$isChosen = !(is_null($inputtedAns)) && $inputtedAns == $value;
							$active = $isChosen ? 'active ' :'';
							$checked = $isChosen ? 'checked ':'';
//							$required = $x==0?"required=\"required\"":"";
							echo "<label class=\"btn btn-info {$active}\">";
							echo "<input type=\"radio\"  name=\"{$answerTag}\" "
								.$checked ."autocomplete=\"off\" value=\"{$value}\">"
								. $ansChoices[$x];
							echo '</label>';
						}
						?>
                    </div>
                </td>
                <!--                自信度-->
                <td class="col-xs-3 center">
                    <div data-toggle="buttons">
						<?php
						$confChoices = ['o','△','X'];
						$confTag = "confidence_{$qNum}";
						//前回入力されていた自信度
						$inputtedConf = $inputtedLog['confidences'][$qNum];
						//1,2,3の範囲
						for ( $y = 0; $y < sizeof($confChoices) ;$y++ ) {
							$value = $y + 1;
							//前回入力されていた値の場合はボタンをアクティブにする
							$isChosen = !(is_null($inputtedConf)) &&  $inputtedConf == $value ;
							$checked = $isChosen ? 'checked':'';
							$active = $isChosen ? 'active':'';
//							$required = $y==0?"required=\"required\"":"";
							echo "<label class=\"btn btn-info {$active}\" >";
							echo "<input type=\"radio\"  name=\"{$confTag}\" "
								."autocomplete=\"off\" {$checked} value=\"{$value}\">";
							echo $confChoices[$y];
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
		//戻るボタン
		if ($curNum > 1) {
			echo $this->Form->button('',[
				'type'=>'submit',
				'name'=>'curNum',
				'value'=>$curNum-1,
				'formaction'=>$curNum-1,
				'class'=>'btn btn-info fui-arrow-left'
			]);
		}
		foreach (range(1, 8) as $buttonNum ) {
			$btnClassAry =  ["btn"];
			if ($notAnsedPages[$buttonNum-1]) {
				$btnClassAry[] = "btn-success";
            }else{
				$btnClassAry[] = "btn-default";
			}
			//現在のページのボタンの色を濃くする
			if ( $buttonNum == $curNum ) {
				$btnClassAry[] = "active";
			}
			//クラス一覧の配列をスペースでつなげて文字列にする
			$btnClass = implode(" ", $btnClassAry);
			//formactionは遷移先
			echo "<button type='submit' name='curNum' value='{$curNum}' formaction= '{$buttonNum}' class='{$btnClass}'>";
			echo "{$buttonNum}</button>";
		}
		//次へボタン
		if ($curNum < 8) {
			echo $this->Form->button('',[
				'type'=>'submit',
				'name'=>'curNum',
				'value'=>$curNum+1,
				'formaction'=>$curNum+1,
				'class'=>'btn btn-info end-btn fui-arrow-right'
			]);
		}
		?>
    </div>
    <br>
    <div class="center">
		<?php
		//完了ボタン
		if ($curNum == 8 ) {
			echo $this->Form->button('完了',[
				'type'=>'button',
				'name'=>'curNum',
				'value'=>$curNum,
				'formaction'=>'result',
				'class'=>'btn btn-success',
                'id' => 'end_answer'
			]);
		}
		?>
    </div>
</form>

<br><br><br><br><br><br><br><br>
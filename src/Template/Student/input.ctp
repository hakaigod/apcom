<?php
/**
 * [模擬試験結果(各解答)の入力ページ]
 *
 * @var \App\View\AppView $this
 * 模擬試験コード
 * @var int $imicode
 * @var string $userID
 * @var string $username
 * @var string $studentName
 * @var string $studentID
 * @var string $role
 * 模擬試験名
 * @var string $imiName
 * 現在表示しているページ番号 currentNum
 * @var Integer $curNum
 * DBから取得した問題一覧
 * @var \App\Model\Entity\MfQe[][] $questions
 * 過去に入力されていた解答と自信度
 * @var array $inputtedLog
 * 1-7ページが解答されているか
 * @var bool $isAnsed
 * 1-8の未解答のページ一覧
 * @var bool[] $notAnsedPages
 */
?>
<?php
function json_safe_encode($data){
	return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>
<!-- タイトルセット -->
<?php $this->start('title'); ?>
応用情報ど.com  -模試入力
<?php $this->end(); ?>

<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<?php $this->end(); ?>

<?php $this->start('script'); ?>
<!--http://qiita.com/cither/items/b98cc4e237dcc8f7e51f-->
<script id="check-script" src="<?= $this->request-> getAttribute('webroot') . "private/js/Input/input.js" ?>"
	
	<?= "isAnsed = " . json_safe_encode($isAnsed)?>
	<?= "curNum = " . json_safe_encode($curNum)?>
></script>
<?php $this->end(); ?>


<?php $this->start('sidebar'); ?>
<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
<tr><td><?= $this->Html->link('過去問題演習',["action" => "yearSelection"])?></td></tr>
<tr><td><?= $this->Html->link('一問一答',["action" => "qaaSelectGenre"])?></td></tr>
<?php $this->end(); ?>
<?php if( !(isset($imiName))):?>
    <br><br>
    <div class="alert alert-danger" role="alert">
        この模擬試験は実施されていません
    </div>
<?php else:?>
    <h3><?= $imiName ?></h3>
    <form name="ansForm" action="<?= $this->Html->Url->build(
		['controller' => 'student', 'action' => 'sendAll',
		 'id' => $userID,'imicode' => $imicode]) ?>
" method="post" id="answer-form">
        <table id="input-table" class="table table-bordered table-striped table-hover" >
            <thead >
            <tr>
                <th class ="center">番号</th>
                <th class ="center">問題文</th>
                <th class ="center">解答</th>
                <th class ="center">自信度</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach (range(1, 10) as $i ): ?>
                <tr>
                    <!--                問題番号-->
                    <td class=" col-sm-12  col-md-1 center">
						<?= $qNum = $questions[ $i - 1 ]['qesnum'] ?>
                    </td>
                    <!--                問題文(最初の10文字のみ)-->
                    <td class=" col-sm-12  col-md-3 sentence">
                        <span>
						<?= mb_substr(strip_tags($questions[ $i - 1 ]['question']),0,10) ?>
                            </span>
                    </td>
                    <!--                解答-->
                    <td class=" col-sm-12  col-md-5 center">
                        <div id="<?= "rejoinder_{$i}"?>" class="answers-div" data-toggle="buttons">
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
								$yet = $value==0 ? 'yet':"";
//							$required = $x==0?"required=\"required\"":"";
								echo "<label class=\"btn btn-info {$yet} {$active}\">";
								echo "<input type=\"radio\" name=\"{$answerTag}\" "
									.$checked ."autocomplete=\"off\" value=\"{$value}\">"
									. $ansChoices[$x];
								echo '</label>';
							}
							?>
                        </div>
                    </td>
                    <!--                自信度-->
                    <td class=" col-sm-12  col-md-3 center">
                        <div id="<?= "conf_{$i}"?>" data-toggle="buttons">
							<?php
							$confChoices = ['circle_white','triangle_white','cross_white'];
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
								$disabled = $inputtedAns === '0' ? 'disabled':'';
//							$required = $y==0?"required=\"required\"":"";
								echo "<label class=\"btn btn-info {$disabled} {$active}\" >";
								echo "<input type=\"radio\" {$disabled} name=\"{$confTag}\" "
									."autocomplete=\"off\" {$checked} value=\"{$value}\">";
								echo $this->Html->image($confChoices[$y] . ".svg", ['alt' => $confChoices[$y]]);
								echo '</label>';
							}
							?>
                        </div>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <div class="center">
			<?php
			//戻るボタン
			if ($curNum > 1) {
				echo $this->Form->button('',[
					'type'=>'submit',
					'name'=>'curNum',
					'value'=>$curNum,
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
					'value'=>$curNum,
					'formaction'=>$curNum+1,
					'class'=>'btn btn-info end-btn fui-arrow-right',
                    'id' => 'next_button'
				]);
			}
			?>
        </div>
        <br>
        <div class="center" id="finish-answer">
			<?php
			//完了ボタン
			if ($curNum == 8 ) {
				echo $this->Form->button('完了',[
					'type'=>'button',
					'class'=>'btn btn-success',
					'id' => 'end_answer'
				]);
			}
			?>
        </div>
    </form>
<?php endif;?>
<br><br><br><br><br><br><br><br>
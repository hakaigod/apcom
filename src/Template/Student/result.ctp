<?php
/**
 *
 * @var \App\View\AppView $this
 * @var string $userID
 * @var string $username
 * @var string $studentName
 * @var string $studentID
 * @var string $role
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
 * 生徒のジャンルごと点数
 * @var array $userScore
 * 全体のジャンルごと平均
 * @var array $wholeAvg
 * ヒストグラムの分布図の百分率の配列
 * @var array $barNumbers
 */
?>

<!-- タイトルセット -->
<?php $this->start('title'); ?>
応用情報ど.com  -模試結果
<?php $this->end(); ?>

<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/qaa.css')?>

<?= $this->Html->css('/private/css/Input/input.css') ?>
<?php $this->end(); ?>
<!-- jsセット -->
<?php $this->start('script'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<!--canvasにグラフを設定するスクリプト-->
<script id="graph-script"
	<?php
	echo ' src="' . $this->request-> getAttribute('webroot') . 'private/js/Input/result.js"';
	echo " user-name = \"{$studentName}さん\"";
    echo " radar-user = " . json_safe_encode(array_values($userScore));
	echo " radar-averages = " . json_safe_encode( array_values($wholeAvg));
	echo " bar-numbers = " . json_safe_encode(array_values($barNumbers));
	?>
        defer>
</script>
<script id="modal-script"
	<?php
	echo ' src="' . $this->request-> getAttribute('webroot') . 'private/js/Input/modal.js"';
	echo " exanum = \"$exanum\"";
	?>
        defer>
</script>
<?php $this->end(); ?>
<?php $this->start('sidebar'); ?>
<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
<?php foreach($hamMenu as $hamName => $hamLink):?>
    <tr><td><?= $this->Html->link($hamName,$hamLink)?></td></tr>
<?php endforeach; ?>
<?php $this->end(); ?>

<?php


?>


<?php if( !(isset($exaname)) || !(isset($average))):?>
    <br><br>
    <div class="alert alert-danger" role="alert">
        この模擬試験は実施されていません
    </div>
<?php else:?>
	<?php if(empty($answers) || empty($correctRates)): ?>
        <div class="alert alert-warning" role="alert">
            まだ入力されていません
        </div>
	<?php else:?>
        <div class="col-md-12 ">
            <div class="exam-title">
	            <?= $exaname?>
            </div>
            <h4>順位:<?= $rank  ?></h4>
            <h4>平均点:<?= round($average * 1.25,1) ?>点</h4>
            <h4><?= $studentName?>さんの成績:<?= round($score * 1.25,1) ?>点</h4>
        </div>
        <!--グラフを表示する要素-->
        <div class="col-sm-12 col-md-7 display-chart">
            <h4>成績分布</h4>
            <canvas id="barChart" ></canvas>
        </div>
        <span class="col-md-1"></span>
        <div class="col-sm-12 col-md-4 display-chart">
            <h4>ジャンルごとの正答率</h4>
            <canvas id="radarChart" ></canvas>
        </div>
       

        <table class="table table-bordered table-striped table-hover">
	        <?php
	        $answersStr = ['未','ア','イ','ウ','エ'];
	        $confidenceStr = ['未','○','△','×'];
	        ?>
            <?= $this->Html->tableHeaders(['番号','問題文','解答', '正答','自信度','○×','正答率'],[],['class' => 'center']); ?>
            <tbody>
			<?php foreach (range(1, 80) as $i ): ?>
                <tr>
                    <th class="col-xs-1 center">
                        <button class="btn-detail btn btn-info full" data-toggle="modal" data-target="#myModal" value="<?= $i?>" id="log-detail<?= $i?>">問:<?= $i?></button>
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

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <!-- ここに出題番号 出典を表示  -->
                    <div id="question-title"></div>
                </h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid" id="result-contents">
                    <!-- 問題を表示 -->
                    <div id="question-sentence"></div>
                    <!--選択肢が画像の場合に表示 -->
                    <div id="qaa-answerpic"></div>
                    <!-- 選択肢を表示 -->
                    <table class="table table-bordered table-striped" id="result-table">
                        <tr>
                            <td>ア</td>
                            <td><div id="question-choice1"></div></td>
                        </tr>
                        <tr>
                            <td>イ</td>
                            <td><div id="question-choice2"></div></td>
                        </tr>
                        <tr>
                            <td>ウ</td>
                            <td><div id="question-choice3"></div></td>
                        </tr>
                        <tr>
                            <td>エ</td>
                            <td><div id="question-choice4"></div></td>
                        </tr>
                    </table>
                    <div id="log-yourans"></div>
                    <div id="log-ans"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary full" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function json_safe_encode($data){
	return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>
<br><br><br><br>
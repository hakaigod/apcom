<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MfExa[] $exams
 * @var array $averages
 */
?>

<!-- タイトルセット -->
<?php $this->start('title'); ?>
試験年度選択
<?php $this->end(); ?>

<!-- CSSセット -->
<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/yearSelection.css') ?>
<?php $this->end(); ?>

<!-- jsセット -->
<?php $this->start('script'); ?>
<?php $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?php $this->end(); ?>

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
	<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
	<tr><td><?= $this->Html->link('過去問題演習',["action" => "yearSelection"])?></td></tr>
	<tr><td><?= $this->Html->link('一問一答',["action" => "qaaSelectGenre"])?></td></tr>
	<tr><td><?= $this->Html->link('パスワード更新',["action" => "updatePass"])?></td></tr>
<?php $this->end(); ?>

<br>

<!-- 以下content -->
<div>
    <!-- header -->
    <h1 class="exam-title">過去問題演習</h1>
	<br/>
    <p class="message">過去の午前問題が解けます。<br/>
        受けたい試験の年度を選択してください。
    </p>
	
    <!-- テーブル   -->
    <div class="year-box">
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered ">
                    <tr><th class="tableTitle col-xs-4">試験年度</th>
	                    <th class="tableTitle col-xs-2">全国合格率</th>
	                    <th class="tableTitle col-xs-3">前回の模試の点数</th>
	                    <th class="tableTitle col-xs-3">全体の平均点</th></tr>
                    <tbody>

                    <!--   行の要素   -->
                    <?php foreach($exams as $exam): ?>
                        <tr>
                            <td>
                                <!-- 試験名とそのリンク-->
                                <div>
                                    <?=
                                    //個人模擬試験へのリンクを生成
                                    //タイトルは平成27年度春のように出力
                                    $this->Html->link( $exam->_getExamDetail()  ,
                                        //practiceExamアクションに飛ぶリンクを生成
                                        //コントローラを指定していないので、今と同じコントローラ
                                        ['action' => 'practiceExam'
	                                        , 'exanum' =>$exam->exanum
	                                        ,'qesnum' => 1],
                                        [ 'class'=>" year-btn btn btn-info full" ]
                                    )
                                    ?>
                                </div>
                            </td>
							<!--	  全国合格率        -->
                            <td><?= number_format($passRate[$exam->exanum-1],1)."%" ?></td>
	                        <!--	 前回の模擬試験の点数    -->
	                        <td><?= $exanumLastScore[$exam->exanum]['exa_sum'] ?></td>
                            <!-- 各回の平均点-->
                            <td><?= $averages[$exam->exanum]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br/>

<!---->
<div>
	<?= $this->Html->link("TOPへ戻る" ,
		[
			'action' => "summary",
            "id" => $user
		],
		[
			'class' =>'btn btn-warning col-xs-offset-5 col-xs-2'
		]);
	?>
</div>
<br/><br/>
<br/><br/>


<?php
/**
 * @var \App\Model\Entity\MfExa $exams
 */
?>


<!-- タイトルセット -->
<?php $this->start('title'); ?>
結果閲覧
<?php $this->end(); ?>

<!-- CSSセット -->
<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/ap.css') ?>
<?= $this->Html->css('/private/css/Student/score.css') ?>
<?php $this->end(); ?>

<!-- jsセット -->
<?php $this->start('script'); ?>
<?php $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?php $this->end(); ?>

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
<?php foreach($hamMenu as $hamName => $hamLink):?>
    <tr><td><?= $this->Html->link($hamName,$hamLink)?></td></tr>
<?php endforeach; ?>
<?php $this->end(); ?>

<!-- 以下content -->

<?php if( !(isset($exams->exanum))):?>
<br><br>
<div class="alert alert-danger" role="alert">
	この模擬試験は実施されていません
</div>
<?php else: ?>


<!--header-->
<div class = "row">
	<div class = "col-md-12">
		<div class = col-md-12>
			<br/>
			<div id = "exam-title">
				<?= $exams->_getExamDetail();?> ～ 解答結果 ～
			</div>
		</div>
	</div>
</div>

<br/>
<p>
	各問題番号を押すと、問題文が全表示されます。
</p>
<br/><br/>

<div class="score-table" >
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-bordered row" id="ans-table">
				<!--	テーブル上部に点数表示	-->
				<caption  class="score-box">
					<p>
						<b class="score" id="score-opt" ><?= $sum ?></b>/100<b class="score">点でした！</b>
					</p>
				</caption>
				<tr class="table-title">
					<th class="table-project col-xs-1">No.</th>
					<th class="table-project col-xs-5">問題文</th>
					<th class="table-project col-xs-2">正否</th>
					<th class="table-project col-xs-2">アナタの解答</th>
					<th class="table-project col-xs-2">答え</th>
				</tr>
				<tbody>
				<!--   行の要素   -->
				<?php foreach (range(1, 80) as $i ): ?>
					<tr>
						<td class="col-xs-1 right" id="qes-no">
							
							<!--		問題No.ボタン ※これを押下するとモータルウィンドウ表示		-->
								<button  type="button" class="select-btn btn btn-info" data-toggle="modal" data-target="#myModal<?= $i?>"> <?= "問".$i ?></button>
								<!-- モーダルウィンドウの中身 -->
								<div class="modal fade" id="myModal<?= $i?>">
									  <div class="modal-dialog">
										    <div class="modal-content">
												        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											      <div class="modal-body">
													<p class="modal-all modal-qesnum"><?= "[ 問 ".$i." ]" ?></p>
													<p class="modal-all modal-qes-text"><?= $this->qaa->viewTextImg($ansbox[$i-1]->question) ?></p>
													<table class="modal-all table modal-table table-bordered  full" >
														<!--	解答選択肢が共通の画像かどうかの判定	-->
														<!--    それぞれ個別に画像がある場合　	-->
														<?php if(empty($ansbox[$i - 1]->answer_pic)): ?>
															<tr>
																<td class="col-xs-1 center">ア</td>
																<td><?= $this->qaa->viewTextImg($ansbox[$i - 1]->choice1) ?></td>
															</tr>
															<tr>
																<td class="col-xs-1 center">イ</td>
																<td><?= $this->qaa->viewTextImg($ansbox[$i - 1]->choice2) ?></td>
															</tr>
															<tr>
																<td class="col-xs-1 center">ウ</td>
																<td><?= $this->qaa->viewTextImg($ansbox[$i - 1]->choice3) ?></td>
															</tr>
															<tr>
																<td class="col-xs-1 center">エ</td>
																<td><?= $this->qaa->viewTextImg($ansbox[$i - 1]->choice4) ?></td>
															</tr>
														<!--	共通の画像がある場合	-->
														<?php else: ?>
															<tr><td><?= $this->qaa->viewTextImg($ansbox[$i - 1]->answer_pic); ?></td></tr>
														<?php endif ?>
													</table>
												<div>
													<?php if(empty($practice[$i])): ?>
														<p class="modal-ans" id="you-ans">アナタの解答： &ensp; </p>
													<?php else: ?>
														<p class="modal-ans" id="you-ans"> アナタの解答：<strong><?= $selectArrayPas[$practice[$i]-1]; ?></strong></p>
													<?php endif; ?>
													<p class="modal-ans" id="pass">答え：<strong><?= $selectArrayPas[$ansbox[$i-1]->answer-1]; ?></strong></p>
												</div>
											</div>
											
											<div class="modal-footer">
												<button type="button" class="btn btn-info full" data-dismiss="modal">閉じる</button>
											</div>
										</div>
									</div>
								</div>
						</td>
						
						<!--    問題文    -->
						<td class="col-xs-5 qes-text" >
							<!--						mb_strimwidthにより、40文字以上の文章は「...」により省略する -->
							<?= mb_strimwidth( $this->qaa->viewTextImg($ansbox[$i-1]->question),0,40,"...") ?>
						</td>
						
						<!--	正否判定		-->
						<td class="col-xs-2">
							<?php if($practice[$i] == $ansbox[$i - 1]->answer):  ?>
								<p class="ans-check" id="correct">〇</p>
							<?php elseif(!isset($practice[$i])): ?>
								<p class="ans-check" >×</p>
							<?php else :?>
								<p class="ans-check" >×</p>
							<?php endif; ?>
						</td>
							
							<!--		解答者の答え		-->
							<td class="col-xs-2 ans">
								<!--	解答者の選んだ解答文表示		-->
								<!--		解答されていない(null)解答を抽出		-->
								<?php if(empty($practice[$i])){
									echo "　";
								}else{
									echo $selectArrayPas[$practice[$i]-1];
								}?>
							</td>
							
							<!--    正答   -->
							<td class="col-xs-2 ans">
								<?= $selectArrayPas[$ansbox[$i-1]->answer-1] ?>
							</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<br/>

<div>
	<?=
	//年度選択画面へのリンクを生成
	$this->Html->link( "年度選択へ戻る" ,
		['action' => 'yearSelection'],
		[ 'class'=>"btn btn-warning top-btn full col-xs-offset-5 col-xs-2" ]
	)
	?>
</div>

<br/><br/><br/>
<?php endif; ?>
























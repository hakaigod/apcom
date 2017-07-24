<?php
/**
 * @var \App\Model\Entity\MfExa $exams
 * @var \App\Model\Entity\MfQe $qes
 * @var \App\Controller\StudentController $ansed
 */
?>

<!-- タイトルセット -->
<?php $this->start('title'); ?>
過去問題
<?php $this->end(); ?>

<!-- CSSセット -->
<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/practiceexam.css') ?>
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
<?php if(!(isset($exams->exanum))):?>
	<br><br>
	<div class="alert alert-danger" role="alert">
		この模擬試験は実施されていません
	</div>
<?php elseif(!(isset($qes->qesnum))) :?>
	<br><br>
	<div class="alert alert-danger" role="alert">
		この問題は実施されていません
	</div>
<?php else: ?>
	
	<!-- 以下content -->
	<div class = "container-fluid">
		<!--header-->
		<div class = "row">
			<div class = "col-md-12">
				<div class = col-md-12>
					<br/>
					<div id = "exam-title">
						<?= $exams->_getExamDetail();?>
					</div>
				</div>
			</div>
		</div>
		
		<!--　出題問題表示　-->
		<div class = "row">
			<div class = "col-md-12">
				<div id = "qaa-question-no">
					<br/>
					<?= "[ 問".$qes->qesnum." ]" ?>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class = "qaa-question">
					<!--問題文-->
					<div>
						<!-- 問題文の画像表示 -->
						<?= $this->qaa->viewTextImg($qes->question) ?>
					</div>
					<br/>
				</div>
			</div>
		</div>
		
		<!--  解答部分	-->
		<!--    解答選択肢が1つの画像のみかどうかで表示方法を分岐	-->
		<!--  通常の選択肢の場合	-->
		<?php if(empty($qes->answer_pic)): ?>
			<form name="ansForm" method="post" >
				<input type="hidden" value="<?= $this->request->getParam("exanum") ?>" name="exanum">
				<div class="row" id="table" data-toggle="buttons">
					<table class="table table-bordered">
						<tbody>
						<tr>
							<td id="button" class="col-xs-1" >
								<!-- class内にactiveを入れることで、ラジオボタンの見た目を選択状態にする(Bootstrapの特性)　-->
								<label class = "btn btn-embossed btn-info full  <?php echo ($ansed==1) ? ' active' : ''; ?>">
									<!--	      nameは変数名、valueはそれに入る値        -->
									<input type = "radio"  id="aa" name="ansSelect" value="1" <?php echo ($ansed==1) ? ' checked ' : ''; ?> >ア
								</label>
							</td>
							<td id="choice" class="col-xs-11">
								<span class="select-choice" id="aa" >
		                            <?= $this->qaa->viewTextImg($qes->choice1)?>
								</span>
							</td>
						</tr>
						
						<tr>
							<td id="button">
								<label class = "btn btn-embossed btn-info full  <?php echo ($ansed==2) ? ' active' : ''; ?>">
									<input type = "radio"  id="aa"  name="ansSelect" value="2" <?php echo ($ansed==2) ? ' checked ' : ''; ?> >イ
								</label>
							</td>
							<td id="choice">
								<span class="select-choice">
		                            <?= $this->qaa->viewTextImg($qes->choice2)?>
								</span>
							</td>
						</tr>
						
						<tr>
							<td id="button">
								<label class = "btn btn-embossed btn-info full  <?php echo ($ansed==3) ? ' active' : ''; ?>">
									<input type = "radio"  id="aa"  name="ansSelect" value="3" <?php echo ($ansed==3) ? ' checked ' : ''; ?> >ウ
								</label>
							</td>
							<td id="choice">
								<span class="select-choice">
		                            <?= $this->qaa->viewTextImg($qes->choice3)?>
								</span>
							</td>
						</tr>
						
						<tr>
							<td id="button">
								<label class = "btn btn-embossed btn-info full <?php echo ($ansed==4) ? ' active ' : ''; ?>" >
									<input type = "radio"  id="aa"  name="ansSelect" value="4" <?php echo ($ansed==4) ? ' checked ' : ''; ?>>エ
								</label>
							</td>
							<td id="choice">
								<span class="select-choice" >
		                            <?= $this->qaa->viewTextImg($qes->choice4)?>
								</span>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				
				<!--  1つの画像の選択肢の場合	-->
				<?php else:?>
				<form name="ansForm" method="post" >
					<input type="hidden" value="<?= $this->request->getParam("exanum") ?>" name="exanum">
					<div class="row" id="table" data-toggle="buttons">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td  class="col-xs-1">
									<!-- class内にactiveを入れることで、ラジオボタンの見た目を選択状態にする(Bootstrapの特性)　-->
									<label id="button" class = "btn btn-top btn-embossed btn-info full  <?php echo ($ansed==1) ? ' active' : ''; ?>">
										<!--	      nameは変数名、valueはそれに入る値        -->
										<input type = "radio" name="ansSelect" value="1" <?php echo ($ansed==1) ? ' checked ' : ''; ?> >ア
									</label>
									
									<label id="button" class = "btn all-choice-btn btn-info full  <?php echo ($ansed==2) ? ' active' : ''; ?>">
										<input type = "radio" name="ansSelect" value="2" <?php echo ($ansed==2) ? ' checked ' : ''; ?> >イ
									</label>
	
									<label id="button" class = "btn all-choice-btn btn-info full  <?php echo ($ansed==3) ? ' active' : ''; ?>">
										<input type = "radio" name="ansSelect" value="3" <?php echo ($ansed==3) ? ' checked ' : ''; ?> >ウ
									</label>
							
									<label id="button" class = "btn all-choice-btn btn-info full <?php echo ($ansed==4) ? ' active ' : ''; ?>" >
										<input type = "radio" name="ansSelect" value="4" <?php echo ($ansed==4) ? ' checked ' : ''; ?>>エ
									</label>
								</td>
								
								<td class="col-xs-11">
									<span class="all-choice-text">
										<?= $this->qaa->viewTextImg($qes->answer_pic); ?>
									</span>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
					<?php endif;?>
					
					<!--  下部のボタン3種類	-->
			<div class="col-md-12">
				<div class="qaa row">
					<!--	前の問題ボタン	-->
					<div class="qaa-back">
						<?php if(($qes->qesnum-1)==0): ?>
							<?= $this->Html->link("<< 前の問題" ,
								['action' => 'practiceExam',
	                                'exanum' =>$exams->exanum,
	                                'qesnum' => $qes->qesnum-1],
								[ 'class' => "btn btn-warning disabled" ]);
							?>
							<?php else: ?>
							<?= $this->Form->button('<< 前の問題' ,
								[
									'class' => 'btn btn-warning',
									'formaction' =>   $qes->qesnum - 1 ,
									'name' => 'into_ques',
									'value' => 1,
									'type' => 'submit'
								]);
							?>
						<?php endif; ?>
					</div>
				
				
				<script language="JavaScript">
	                function cfm() {
	                   var flag = confirm("結果画面に移ります。\n" +
		                                  "本当に解答を終了しますか？");
	                   return flag;
	                }
				</script>
				
				<!--	解答を終了するボタン	-->
					<div  class="qaa-score">
						<?=
							 $this->Form->button("解答を終了する" ,
								 [
									 'onclick'=>'return cfm()', //確認ダイアログに遷移
									 'class' => 'btn btn-danger',
									 'formaction'=> $this->Url->build(['action' =>'score',
										                                'exanum' => $exams->exanum]),
									 'name' => 'into_ques',
									 'value' => $qes->qesnum,
									  'type' => 'submit'
								 ]);
						?>
					</div>
				
				<!--	次の問題ボタン	-->
					<div  class="qaa-next">
						<?php if ($qes->qesnum==80): ?>
							<?= $this->Html->link("次の問題 >>" ,
								['action' => 'practiceExam',
	                                'exanum' =>$exams->exanum ,
	                                'qesnum' =>$qes->qesnum + 1 ],
								[ 'class' => "btn btn-warning disabled"
								]);
							?>
						<?php else: ?>
								<?= $this->Form->button('次の問題 >>' ,
									[
										'class' => 'btn btn-warning',
										'formaction' =>   $qes->qesnum + 1 ,
										'name' => 'into_ques',
										'value' => -1,
										'type' => 'submit'
									]);
								?>
						<?PHP endif;  ?>
					</div>
				</div>
		</form>
<?php endif; ?>
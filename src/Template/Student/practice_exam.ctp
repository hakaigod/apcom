<?php
/**
 * @var \App\Model\Entity\MfExa $exams
 * @var \App\Model\Entity\MfQe $qes
 *  * @var \App\Model\Entity\MfQe $sesAns
 */
?>


<!-- タイトルセット -->
<?php $this->start('title'); ?>
<?= "平成".$exams->jap_year . "年度". $exams->exaname ." 模擬試験" ?>
<?php $this->end(); ?>


<!-- CSSセット -->
<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/practiceexam.css') ?>
<?php $this->end(); ?>


<!-- jsセット -->
<?php $this->start('script'); ?>
<?php $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?php $this->end(); ?>


<!-- ユーザーネームセット -->
<?php $this->start('username'); ?>
managerrrrr
<?php $this->end(); ?>


<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><a>トップページ</a></td></tr>
<tr><td><a>一問一答</a></td></tr>
<tr><td><a>結果閲覧</a></td></tr>
<tr><td><a>点数入力</a></td></tr>
<tr><td><a>設定</a></td></tr>
<?php $this->end(); ?>




<!-- 以下content -->
<div class = "container-fluid">
	<!--header-->
	<div class = "row">
		<div class = "col-md-12">
			<div class = col-md-12>
				<br/>
				<div id = "exam-title">
					<?= "平成".$exams->jap_year . "年度 ". $exams->exaname ?>
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
					<?=  ($qes -> question) ?>
				</div>
				<br/>
			</div>
		</div>
	</div>
	
<!--	-->
	<!--  解答部分	-->
	<form name="ansForm" method="post">
		
	<div class="row" id="table" data-toggle="buttons">
		<table class="table table-bordered">
				<tbody>
				<tr>
					<td id="button" class="col-xs-1" >
						<label class = "btn btn-embossed btn-primary full">
					<!--	      nameは変数名、valueはそれに入る値        -->
							<input type = "radio"  id="aa" name="ansSelect" value="1"
							<?php echo ($sesAns==1) ? ' checked' : ''; ?>>ア
						</label>
					</td>
					<td id="choice" class="col-xs-11">
						<span class="select-choice" id="aa" >
							<?= ($qes -> choice1); ?>
						</span>
					</td>
				</tr>
				
				<tr>
					<td id="button">
						<label class = "btn btn-embossed btn-primary full">
							<input type = "radio"  id="aa"  name="ansSelect"  value="2">イ
						</label>
					</td>
					<td id="choice">
						<span class="select-choice">
							<?= ($qes -> choice2); ?>
						</span>
					</td>
				</tr>
				<tr>
					
					<td id="button">
						<label class = "btn btn-embossed btn-primary full">
							<input type = "radio"  id="aa"  name="ansSelect" value="3">ウ
						</label>
					</td>
					<td id="choice">
						<span class="select-choice">
							<?= ($qes -> choice3); ?>
						</span>
					</td>
				</tr>
				
				<tr>
					<td id="button">
						<label class = "btn btn-embossed btn-primary full">
							<input type = "radio"  id="aa"  name="ansSelect" value="4">エ
						</label>
					</td>
					<td id="choice">
						<span class="select-choice" >
							<?= ($qes -> choice4); ?>
						</span>
					</td>
				</tr>
				</tbody>
		</table>
	</div>
	
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
							[ 'class' => "btn btn-warning disabled" ]
						);
						?>
						<?php else: ?>
						<?= $this->Form->button('<< 前の問題' ,
							[
								'class' => 'btn btn-warning',
								'formaction' =>   $qes->qesnum - 1 ,
								'type' => 'submit'
//								'value' => 'ansSelect'
						]
						);
						?>
					<?php endif; ?>
				</div>
			
			
				<!--	解答を終了するボタン	-->
				<div  class="qaa-score">
					<?=
						 $this->Form->button("解答を終了する" ,
							 [
								 'class' => 'btn btn-info',
								 'formaction' =>  '../../score',
								 'type' => 'submit',
								 'value' => '' ]
						 );
					?>
				</div>
			
			
			
			<!--	次の問題ボタン	-->
				<div  class="qaa-next">
					<?php if ($qes->qesnum==80): ?>
						<?= $this->Html->link("次の問題 >>" ,
							['action' => 'practiceExam',
                                'exanum' =>$exams->exanum ,
                                'qesnum' =>$qes->qesnum + 1 ],
							[ 'class' => "btn btn-warning disabled" ]
						);
						?>
					<?PHP else: ?>
							<?= $this->Form->button('次の問題 >>' ,
								[
									'class' => 'btn btn-warning',
									'formaction' =>   $qes->qesnum + 1 ,
									'type' => 'submit'
//									'value' => $ansnum
								]);
							?>
							
							
					<?PHP endif;  ?>
				</div>
			</div>
	
	</form>

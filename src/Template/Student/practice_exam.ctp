<?php
/**
 * @var \App\Model\Entity\MfExa $exams
 * @var \App\Model\Entity\MfQe $qes
 */
?>


<!-- タイトルセット -->
<?php $this->start('title'); ?>
模擬試験
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
	
	
	<!--ここから出題問題表示-->
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
	
	<div class="col-md-12">
		<div class="qaa-select-answer">
			<div class="row">
		<!--	    ラジオボタンのチェックボックス化を直す			-->
				<ul style="list-style:none;" data-toggle="buttons-radio" class="button-group">
					<li>
						<input type = "button" class = "btn btn-embossed btn-primary" value = "ア" >
						<span class="select-choice">
<!--                        --><?php
//                            str_replace(,$qes->qesnum."a.gif",);
                            echo ($qes -> choice1)
//                        ?>
                </span>
					</li>
					<li>
						<input type = "button" class = "btn btn-embossed btn-primary" value = "イ" >
						<span class="select-choice">
<!--                        --><?php
//                        str_replace(,$qes->qesnum."i.gif",);
							echo ($qes -> choice2) ?>
                </span>
					</li>
					<li>
						<input type = "button" class = "btn btn-embossed btn-primary" value = "ウ" >
						<span class="select-choice">
<!--                        --><?php
//                        str_replace(,$qes->qesnum."u.gif",)
							echo ($qes -> choice3) ?>
                </span>
					</li>
					
					<li>
						<input type = "button" class = "btn btn-embossed btn-primary" value = "エ" >
						<span class="select-choice">
<!--                        --><?php
//                        str_replace(,$qes->qesnum."e.gif",)
							echo ($qes -> choice4) ?>
                </span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="qaa row">
				<div class="qaa-back">
					<?php
						if(($qes->qesnum-1)==0){
							echo $this->Html->link("<< 前の問題" ,
								['action' => 'practiceExam', $exams->exanum,$qes->qesnum-1],
								[ 'class'=>"btn btn-warning disabled" ]
							);
						}else{
							echo $this->Html->link("<< 前の問題" ,
								['action' => 'practiceExam', $exams->exanum,$qes->qesnum-1],
								[ 'class'=>"btn btn-warning" ]
							);
						}
					?>
				</div>
				
				<div  class="qaa-score">
					<?php
						echo $this->Html->link("解答を終了する" ,
							['action' => 'score'],
							[ 'class'=>"btn btn-warning" ]
						);
					?>
				</div>
				
				
				<div  class="qaa-next">
					<?php
					if ($qes->qesnum==80){
						echo $this->Html->link("次の問題 >>" ,
							['action' => 'practiceExam', $exams->exanum,$qes->qesnum+1],
							[ 'class'=>"btn btn-warning disabled" ]
						);
					}else{
						echo $this->Html->link("次の問題 >>" ,
							['action' => 'practiceExam', $exams->exanum,$qes->qesnum+1],
							[ 'class'=>"btn btn-warning" ]
						);
					}
					?>
			</div>
			
			</div>
		</div>
	</div>
</div>
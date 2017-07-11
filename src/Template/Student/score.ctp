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
<?= $this->Html->css('/private/css/Student/score.css') ?>
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


<br/><br/><br/>
<p class="message">問題番号をクリックすると、各問題の答えが確認できます。</p>

<div class="ans-table" >
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered col-xs-12" id="ans-table">
			
			<tr><?= $sum  ?></tr>
			<tr class="table-title"><th>No.</th><th>問題文</th><th>正否</th><th>アナタの解答</th><th>答え</th></tr>
			<tbody>
			<!--   行の要素   -->
			<!--  tr...行  tb...列		-->
			<?php foreach (range(1, 80) as $i ): ?>
				<tr>
					<!--		問題No.		-->
					<td class="col-xs-1 right" id="qes-no">
						<p class="qes-no"><?= "問".$i."." ?></p>
					</td>
					
					<!--    問題文    -->
					<td class="col-xs-6">
<!--						mb_strimwidthにより、40文字以上の文章は「...」により省略する -->
						<?= mb_strimwidth( $this->qaa->viewTextImg($ansbox[$i-1]->question),0,40,"...") ?>
					</td>
					
					<!--	正否判定		-->
					<td class="col-xs-1">
						<?php if($practice[$i] == $ansbox[$i - 1]->answer):  ?>
							<p class="ans-check">〇</p>
						<?php else :?>
							<p class="ans-check">×</p>
						<?php endif; ?>
					</td>
					
					<!--		解答者の答え		-->
					<td class="col-xs-2">
						<!--	解答者の選んだ解答文表示		-->
						<!--		解答されていない(null)解答を抽出		-->
						<?php if(empty($practice[$i])){
							echo "未解答";
						//	解答文に画像が含まれていたら文字制限を解除し表示
						}elseif(strpos($ansbox[$i-1]["choice".$practice[$i]],'img')) {
							echo $this->qaa->viewTextImg($ansbox[$i - 1]["choice" . $practice[$i]]);
						}else{
							//	mb_strimwidthにより、12文字以上の文章は「...」により省略する
							echo mb_strimwidth($this->qaa->viewTextImg($ansbox[$i - 1]["choice" . $practice[$i]]), 0, 12, "...");
							
						}?>
					</td>
					
					<!--    正答   -->
					<td class="col-xs-2">
						<!--	正答の解答文表示		-->
						<!--  解答文に画像が含まれていたら文字制限を解除し表示-->
						<?php if(strpos($ansbox[$i - 1]["choice" . $ansbox[$i - 1]->answer],'img')){
							echo $this->qaa->viewTextImg($ansbox[$i - 1]["choice" . $ansbox[$i - 1]->answer]);
						}else{
							//	mb_strimwidthにより、12文字以上の文章は「...」により省略する
							echo mb_strimwidth($this->qaa->viewTextImg($ansbox[$i - 1]["choice" . $ansbox[$i - 1]->answer]), 0, 12, "...");
						}
						?>
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
	$this->Html->link( "TOPへ戻る" ,
		['action' => 'yearSelection'],
		[ 'class'=>" top-btn btn btn-warning full col-xs-offset-5 col-xs-2" ]
	)
	?>
</div>

<br/><br/><br/>
























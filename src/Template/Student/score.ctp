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
				<?= "平成".$exams->jap_year . "年度 ". $exams->exaname ?>
			</div>
		</div>
	</div>
</div>
























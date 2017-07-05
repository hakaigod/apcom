
<?php
/**
 * @var \App\View\AppView $this
 * @var string $userID
 * @var string $username
 * @var string $studentName
 * @var string $studentID
 * @var string $role
 */
?>

<!-- タイトルセット -->
<?php $this->start('title'); ?>
応用情報ど.com  -メニュー
<?php $this->end(); ?>

<!-- CSSセット -->
<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Manager/index.css') ?>
<?= $this->Html->css('/private/css/Input/summary.css') ?>
<?php $this->end(); ?>

<!-- jsセット -->
<?php $this->start('script'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<!--canvasにグラフを設定するスクリプト-->
<script id="check-script"
	<?php
	echo ' src="' . $this->request-> getAttribute('webroot') . 'private/js/Input/summary.js"';
	echo " user-name = \"{$studentName}さん\"";
	$dates = array_column($imiDetails,'date');
	krsort($dates);
	echo " line-dates = " . json_safe_encode( array_values($dates) );
	$scores = array_column($imiDetails,'score');
	krsort($scores);
	echo " line-student-score = " . json_safe_encode( array_values($scores) );
	$averages =  array_column($imiDetails,'avg');
	krsort($averages);
	echo " line-averages = " . json_safe_encode( array_values($averages) );
	echo " radar-user = " . json_safe_encode(array_values($userAvg));
	echo " radar-averages = " . json_safe_encode( array_values($wholeAvg));
	?>
	    defer>
</script>
<?php $this->end(); ?>

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
<tr><td><?= $this->Html->link('過去問題演習',["action" => "yearSelection"])?></td></tr>
<tr><td><?= $this->Html->link('一問一答',["action" => "qaaSelectGenre"])?></td></tr>
<tr><td><a href="">パスワード更新</a></td></tr>
<?php $this->end(); ?>
<br>

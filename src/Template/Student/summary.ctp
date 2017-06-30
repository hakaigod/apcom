
<?php
/**
 * @var \App\View\AppView $this
 * @var string $userID
 * @var array $answeredImis
 *
 */
?>

<!-- タイトルセット -->
<?php $this->start('title'); ?>
学生メニュー
<?php $this->end(); ?>

<!-- CSSセット -->
<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Manager/index.css') ?>
<?php $this->end(); ?>

<!-- jsセット -->
<?php $this->start('script'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?php $this->end(); ?>

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request->getAttribute('webroot') ."/student" ?>">トップページ</a></td></tr>
<tr><td><a href="">パスワード更新</a></td></tr>
<?php $this->end(); ?>
<br>
<div class="panel panel-danger">
    <div class="panel-heading">
        まだ入力されていない模擬試験があります
    </div>
    <ul  style="list-style:none;">
		<?php for($i=0;$i<4;$i++):?>
            <li>
                <!--                TODO:未入力模擬試験一覧を表示-->
                aa
            </li>
		<?php endfor;?>
    </ul>
</div>


<!--グラフを表示する要素-->
<div class="col-xs-8">
    <canvas id="lineChart" ></canvas>
</div>
<!--グラフを表示する要素-->
<div class="col-xs-4">
    <canvas id="radarChart" ></canvas>
</div>
<!--canvasにグラフを設定するスクリプト-->
<script id="check-script"
    <?= 'src="' . $this->request-> getAttribute('webroot') . 'private/js/Input/summary.js"'?>
    
    <?= "user-name = \"{$username}さん\""?>
    <?= "line-dates = " . json_safe_encode( array_column($answeredImis,'date'))?>
	<?= "line-student-score = " . json_safe_encode( array_column($answeredImis,'studentScore'))?>
	<?= "line-averages = " . json_safe_encode( array_column($answeredImis,'average'))?>
	<?= "radar-tech-user = " . json_safe_encode( array_column($answeredImis,'average'))?>
	<?= "radar-tech-user = " . json_safe_encode( array_column($answeredImis,'average'))?>
	<?= "radar-tech-user = " . json_safe_encode( array_column($answeredImis,'average'))?>
	<?= "radar-tech-avg = " . json_safe_encode( array_column($answeredImis,'average'))?>
	<?= "radar-tech-avg = " . json_safe_encode( array_column($answeredImis,'average'))?>
	<?= "radar-tech-avg = " . json_safe_encode( array_column($answeredImis,'average'))?>
 
 
>
</script>
<br><br>
<div class="col-xs-12">
    <h4>今まで受験した模擬試験</h4>
</div>
<table class="table table-bordered table-striped table-hover">
	<?= $this->Html->tableHeaders(['試験名','平均', '点数','順位'],[],['class' => 'center']); ?>
    <tbody>
	<?php
	foreach($answeredImis as $imi): ?>
        <tr>
            <th class="center"><?=
                $this->Html->link($imi['name'],
                                  ['controller' => 'student',
                                   'action' => 'result',
                                   'id' => $userID,
                                   'imicode' => $imi['imicode']]);
                ?>
            </th>
            <td class="center"><?= $imi['average']?></td>
            <td class="center"><?= $imi['studentScore']?></td>
            <td class="center"><?= $imi['rank'] ?> </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>
<?php
function json_safe_encode($data){
	return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>


<?php
/**
 * @var \App\View\AppView $this
 * @var string $username
 * //name,date,avg,score,rankのキーをもつ
 * @var array $imiDetails
 * //tech,man,strのキーをもつ
 * @var float[] $userAvg
 * @var float[] $wholeAvg
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
<?php if($imiDetails): //TODO:なっとらん?>
<div class="panel panel-danger ">
    <div class="panel-heading">
        まだ入力されていない模擬試験があります
    </div>
    <ul  style="list-style:none;">
	    <?php foreach($imiDetails as $imi): ?>
            <?php if($imi['score'] === null):?>
                <li class="text-danger">
                    <strong><u>
			                <?= $this->Html->link(
				                "{$imi['date']} {$imi['name']}",
				                ['controller' => 'student',
				                 'action' => 'input',
				                 'id' => $userID,
				                 'imicode' => $imi['imicode'],
				                 'linkNum' => 1
				                ],
				                ['class' => 'text-danger ']
			                ); ?>
                        </u></strong>
                </li>
		    <?php endif;?>
		<?php endforeach;?>
    </ul>
</div>
<?php endif;?>

<!--グラフを表示する要素-->
<div class="col-xs-7">
    <h4 class="">成績の推移</h4>
    <canvas id="lineChart" ></canvas>
</div>
<!--グラフを表示する要素-->
<div class="col-xs-5">
    <h4>ジャンルごとの正答率</h4>
    <canvas id="radarChart" ></canvas>
</div>
<!--canvasにグラフを設定するスクリプト-->
<script id="check-script"
    <?= 'src="' . $this->request-> getAttribute('webroot') . 'private/js/Input/summary.js"'?>
    
    <?= "user-name = \"{$username}さん\""?>
    <?= "line-dates = " . json_safe_encode( array_column($imiDetails,'date'))?>
	<?= "line-student-score = " . json_safe_encode( array_column($imiDetails,'score'))?>
	<?= "line-averages = " . json_safe_encode( array_column($imiDetails,'avg'))?>
	<?= "radar-user = " . json_safe_encode(array_values($userAvg))?>
	<?= "radar-averages = " . json_safe_encode( array_values($wholeAvg))?>
>
</script>
<br><br>
<div class="col-xs-12">
    <h4>模擬試験一覧</h4>
</div>
<!--TODO:逆順にする-->
<table class="table table-bordered table-striped table-hover">
	<?= $this->Html->tableHeaders(['実施日','試験名','平均', '点数','順位'],[],['class' => 'center']); ?>
    <tbody>
	<?php
	foreach($imiDetails as $imi): ?>
        <tr>
            <td class="center col-xs-2"><?= $imi['date']?></td>
            <th class="col-xs-7">
	            <?php if($imi['score'] === null):?>
                    <span class="label label-danger">未</span>
	            <?php else:?>
                    <span class="label label-success">済</span>
                <?php endif;?>
	            <?= $this->Html->link($imi['name'],
	                                  ['controller' => 'student',
	                                   'action' => 'result',
	                                   'id' => $userID,
	                                   'imicode' => $imi['imicode']]);
	            ?>
            </th>
            <td class="center col-xs-1"><?= $imi['avg']?></td>
            <td class="center col-xs-1"><?= ($imi['score'] !== null)?$imi['score']:""?></td>
            <td class="center col-xs-1"><?= ($imi['rank'] !== null)?$imi['rank']:"" ?> </td>
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

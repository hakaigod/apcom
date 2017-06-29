
<?php
/**
 * @var \App\View\AppView $this
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
		<?php for($i=0;$i<10;$i++):?>
            <li>
                <!--                TODO:未入力模擬試験一覧を表示-->
                aa
            </li>
		<?php endfor;?>
    </ul>
</div>


<!--グラフを表示する要素-->
<div class="col-xs-offset-1 col-xs-10">
    <canvas id="myChart" ></canvas>
</div>
<!--canvasにグラフを設定するスクリプト-->
<script>

    let ctx = document.getElementById('myChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'line',
        data: {
            //模擬試験実施の日付(平成24年 春 二回目?)など
            labels: <?= json_safe_encode( array_column($answeredImis,'date'))?>,
            datasets: [{
                //生徒の名前
                label: <?= json_safe_encode($username . "さん")?>,
                data: <?= json_safe_encode( array_column($answeredImis,'studentScore'))?>,
                fill: false,
                borderWidth: 3,
                borderColor: "rgba(201,60,58,0.8)",
                pointBackgroundColor: "rgba(201,60,58,0.6)",
                pointBorderColor: "rgba(201,60,58,0.4)",
                pointBorderWidth: 8,
                lineTension: 0
            }, {
                //
                label: '平均点',
                data: <?= json_safe_encode(array_column($answeredImis,'average'))?>,
                fill: false,
                borderWidth: 3,
                borderColor: "rgba(2,63,138,0.8)",
                pointBackgroundColor: "rgba(2,63,138,0.6)",
                pointBorderColor: "rgba(2,63,138,0.4)",
                pointBorderWidth: 8,
                lineTension: 0
            }]
        },
        options:{
            responsive:true,
            animation:{
                easing:'easeOutQuint',
                duration:500
            },
            scales: {
                yAxes: [{
                    ticks: {
                        max:80,
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
<br><br>
<div class="col-xs-12">
    <h4>今まで受験した模擬試験</h4>
</div>
<table class="table table-bordered table-striped table-hover">
    <!--    TODO:順位表示-->
	<?= $this->Html->tableHeaders(['試験名','平均', '点数'],[],['class' => 'center']); ?>
    <tbody>
	<?php
	foreach($answeredImis as $imi): ?>
        <tr>
            <!--            TODO:編集へのリンクにする-->
            <th class="center"><?=
                $this->Html->link($imi['name'],['action' => 'result','imicode' => $imi['imicode']]);
                ?>
            </th>
            <td class="center"><?= round($imi['average'],1)?></td>
            <td class="center"><?= $imi['studentScore']?></td>
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

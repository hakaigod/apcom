
<?php
/**
 * @var \App\View\AppView $this
 * @var String $stuName
 * @var string[] $dates
 * @var int[] $averages
 * @var int[] $stuScores
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

<!-- ユーザーネームセット -->
<?php $this->start('username');
echo $stuName;
$this->end();
?>

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request->getAttribute('webroot') ."/student" ?>">トップページ</a></td></tr>
<tr><td><a href="">パスワード更新</a></td></tr>
<?php $this->end(); ?>

<h3>学生メニュー</h3>

<!--グラフを表示する要素-->
<canvas id="myChart"></canvas>
<!--canvasにグラフを設定するスクリプト-->
<script>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            //模擬試験実施の日付(平成24年 春 二回目?)など
            labels: <?= json_safe_encode($dates)?>,
            datasets: [{
                //生徒の名前
                label: <?= json_safe_encode($stuName . "さん")?>,
                data: <?= json_safe_encode($stuScores)?>,
                backgroundColor: "rgba(30,20,80,1)",
                fill: false,
                lineTension: 0
            }, {
                //
                label: '平均点',
                data: <?= json_safe_encode($averages)?>,
                backgroundColor: "rgba(200,160,90,1)",
                fill: false,
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
<table class="table table-bordered table-striped table-hover">
	<?php
	foreach ($sums as $sum): ?>
        <tr>
            <td><?= $sum->imicode ?></td>
            <td><?= $sum->imisum ?></td>
        </tr>
	<?php endforeach; ?>
</table>
<?php
function json_safe_encode($data){
	return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>

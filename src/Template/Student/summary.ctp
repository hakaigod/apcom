
<?php
/**
 * @var \App\View\AppView $this
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

<!-- ユーザーネームセット -->
<?php $this->start('username');
echo $name->stuname;
$this->end();
?>

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request->getAttribute('webroot') ?>/Student">トップページ</a></td></tr>
<tr><td><a href="">パスワード更新</a></td></tr>
<?php $this->end(); ?>

<!--グラフを表示する要素-->
<canvas id="myChart"></canvas>
<!--canvasにグラフを設定するスクリプト-->
<script>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            datasets: [{
                label: 'apples',
                data: [12, 19, 3, 17, 6, 3, 0],
                backgroundColor: "rgba(0,0,0,1)",
                fill: false,
                lineTension: 0
            }, {
                label: 'oranges',
                data: [2, 29, 5, 5, 2, 3, 10],
                backgroundColor: "rgba(0,0,0,1)",
                fill: false,
                lineTension: 0
            }]
        },
        options:{
            responsive:true,
            animation:{
                easing:'easeOutQuint',
                duration:500
            }
        }
    });
</script>
<table class="table table-bordered table-striped table-hover">
	<?php
	foreach ($answers as $answer): ?>
        <tr>
            <td><?= $answer->imicode ?></td>
            <td><?= $answer->qesnum ?></td>
        </tr>
	<?php endforeach; ?>
</table>

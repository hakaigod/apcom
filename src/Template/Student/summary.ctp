
<?php
/**
 * @var \App\View\AppView $this
 * @var String $stuName
 * @var \App\Model\Entity\TfSum[] $sums
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
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            datasets: [{
                label: 'apples',
                data: <?= json_safe_encode(trimRow($sums, 'imisum'))?>,
                backgroundColor: "rgba(0,0,0,1)",
                fill: false,
                lineTension: 0
            }, {
                label: 'oranges',
                data: <?= json_safe_encode(trimRow($sums, 'imisum'))?>,
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
	foreach ($sums as $sum): ?>
        <tr>
            <td><?= $sum->imicode ?></td>
            <td><?= $sum->imisum ?></td>
        </tr>
	<?php endforeach; ?>
</table>
<?php
function trimRow($data,$rowName) {
    if ($data instanceof \Cake\Datasource\EntityInterface) {
	    $result=[];
	    foreach ($data as $item) {
		    $result[] = $item->get($rowName);
	    }
	    return $result;
    }else{
        return null;
    }
}
function json_safe_encode($data){
	return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>
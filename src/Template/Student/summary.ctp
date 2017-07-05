
<?php
/**
 * @var \App\View\AppView $this
 * @var string $userID
 * @var string $username
 * @var string $studentName
 * @var string $studentID
 * @var string $role
 * @var array $logoLink
 * name,date,avg,score,rankのキーをもつ
 * @var array $imiDetails
 * tech,man,strのキーをもつ
 * @var float[] $userAvg
 * @var float[] $wholeAvg
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
	$conv = function (array &$array):array {
		krsort($array);
		foreach ($array as &$value) { isset($value) ? $value *= 1.25 : null; }
        return $array;
    };
	$scores = array_column($imiDetails,'score');
	$scores = $conv($scores);
	echo " line-student-score = " . json_safe_encode( array_values($scores) );
	$averages =  array_column($imiDetails,'avg');
	$averages = $conv($averages);
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
<tr><td><?= $this->Html->link('パスワード更新',["action" => "updatePass"])?></td></tr>
<?php $this->end(); ?>
<br>

<?php
//score列にnullを含む場合
//3番目のtrueは型を比較するか(==か===かの違い)
if(in_array(null,array_column($imiDetails, 'score'),true) && $role == 'student' ):?>
<div class="panel panel-danger ">
    <div class="panel-heading">
        まだ入力されていない模擬試験があります
    </div>
    <ul  style="list-style:none;">
	    <?php
        $current = 0;
        $max = 3;
        for( ; $current < count($imiDetails) && $current < $max;$current++): ?>
            <?php
            $imi = $imiDetails[$current];
            if($imi['score'] === null):?>
                <li class="text-danger">
                    <u>
			                <?php
                            $imiTitle ="{$imi['date']} {$imi['name']}";
			
			                echo $this->Html->link(
				                $imiTitle,
				                [ 'controller' => 'student',
				                  'action'     => 'input',
				                  'imicode'    => $imi[ 'imicode' ],
				                  'linkNum'    => 1
				                ],
				                [ 'class' => 'text-danger ' ]
			                );
			                ?>
                    </u>
                </li>
		    <?php endif;?>
		<?php endfor;?>
        <?php
        if ($current < count($imiDetails)) {
            echo "<u>";
            echo $this->Html->link(
	            "もっと見る",
                "#imitation-list",
                [ 'class' => 'text-primary' ]
            );
            echo "</u>";
        }
        ?>
    </ul>
</div>
<?php endif;?>

<!--グラフを表示する要素-->
<div class="col-sm-12 col-md-7 display-chart">
    <h4 class="">成績の推移</h4>
    <canvas id="lineChart" ></canvas>
</div>
<!--グラフを表示する要素-->
<div class="col-sm-12 col-md-5 display-chart">
    <h4>ジャンルごとの正答率</h4>
    <canvas id="radarChart" ></canvas>
</div>

<br><br>
<div id="imitation-list" class="col-xs-12">
    <h4>模試の一覧</h4>
</div>
<table id="summary-table" class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class ="center">実施日</th>
        <th class ="center">試験名</th>
        <th class ="center">平均</th>
        <th class ="center">点数</th>
        <th class ="center">順位</th>
    </tr>
    </thead>
    <tbody>
	<?php
	foreach($imiDetails as $imi): ?>
        <tr>
            <td data-label="実施日" class="center col-sm-12 col-md-2"><?= $imi['date']?></td>
            <td class="col-sm-12 col-md-6">
	            <?php if($imi['score'] === null):?>
                    <span class="label label-danger">未</span>
	            <?php else:?>
                    <span class="label label-success">済</span>
                <?php endif;?>
	            <?php
                $titleArray = ['controller' => 'student', 'imicode' => $imi['imicode']];
                if ($imi['score'] === null) {
                    $titleArray['action'] = 'input';
                    $titleArray['linkNum'] = 1;
                }else{
                    $titleArray['action'] = 'result';
                    $titleArray['id'] = $studentID;
                }
                if ($role == 'manager' && !(isset($imi['score']))) {
                    echo $imi[ 'name' ];
                }else {
	                echo $this->Html->link($imi[ 'name' ], $titleArray);
                }
	            ?>
                &nbsp;
	            <?php
                if ($imi['score'] !== null && $role != 'manager') {
	                echo $this->Html->link("[編集]",
	                                  [ 'controller'  => 'student',
	                                    'action'      => 'input',
	                                    'imicode'     => $imi[ 'imicode' ],
                                        'linkNum' => 1 ],
	                                  [ 'class' => 'text-muted' ]);
                }
	            ?>
            </td>
            <td data-label="平均" class="center col-sm-12 col-md-1"><?= round($imi['avg'] * 1.25,1)?></td>
            <td data-label="点数" class="center col-sm-12 col-md-1"><?= ($imi['score'] !== null)? round($imi['score'] * 1.25,1):"　"?></td>
            <td data-label="順位" class="center col-sm-12 col-md-1"><?= ($imi['rank'] !== null)? $imi['rank'] :"　" ?> </td>
           
            
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

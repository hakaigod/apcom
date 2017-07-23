<!-- タイトルセット -->
<?= $this->start('title');?>
ジャンル選択
<?= $this->end();?>

<!-- CSSセット -->
<?= $this->start('css');?>
<?= $this->Html->css('/private/css/Student/qaa.css')?>
<?= $this->end();?>

<!-- jsセット -->
<?= $this->start('script');?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js')?>
<?= $this->Html->script('/private/js/Student/check.js')?>
<?= $this->Html->script('/private/js/Student/reset.js')?>
<?= $this->end();?>

<!-- ユーザーネームセット -->
<?= $this->start('username');?>
Student
<?= $this->end();?>

<!-- サイドバーセット -->
<?= $this->start('sidebar');?>
<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
<?php foreach($hamMenu as $hamName => $hamLink):?>
    <tr><td><?= $this->Html->link($hamName,$hamLink)?></td></tr>
<?php endforeach; ?>
<?= $this->end();?>

<!-- 以下content -->
<div class="container-fluid">
    <div class="row">
        <div class=col-md-12>
            <div id= "qaa-title">
                一問一答
            </div>
            <div id="qaa-sub">
                ジャンル選択
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p id="qaa-explanation">
                試験ジャンルを設定すると、一問一答形式で対応ジャンルの設問が出題されます。<br>
                [詳細]を押すことで現在の総合回答数とジャンル別の正答率を確認することができます。<br>
                なお、一問一答での回答結果は結果一覧には登録されません。<br>
            </p>
        </div>
    </div>

    <div class= "row">
        <div class="col-md-12">
            <div class="genre-container">
                <div class="caption-box">
                    <!--枠線の上に重ねる文字-->
                    <div class="caption"><p>ジャンル一覧</p></div>
                    <!--ジャンル選択フォーム-->
                    <?php
                    echo $this->Form->create('',['type'=>'post',
                        'url'=>['action'=>'qaaQuestion','question_num'=>1]]);
                    $options=[
                        //valueと表示文字の設定
                        '1'=>'テクノロジ',
                        '2'=>'ストラテジ',
                        '3'=>'マネジメント'
                    ];
                    //name配列と対応するoptionの選択
                    echo $this->Form->select
                    ('genre',
                        $options,
                        [
                            'multiple'=>'checkbox',
                            'data-toggle'=>"checkbox"
                        ]
                    ) ?>
                </div>
                <!--決定ボタン-->
                <div class="center">
                    <?= $this->Form->button
                    ('問題開始',
                        array(
                            'type'=>'submit',
                            'class'=>'btn btn-info',
                            'id'=>'form1'
                        )
                    );?>
                    <?= $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>

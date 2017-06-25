<!-- タイトルセット -->
<?= $this->start('title'); ?>
ジャンル選択
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/qaa.css') ?>
<?= $this->end(); ?>

<!-- jsセット -->
<?= $this->start('script'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?= $this->Html->script('/private/js/Student/check.js') ?>
<?= $this->end(); ?>

<!-- ユーザーネームセット -->
<?= $this->start('username'); ?>
Student
<?= $this->end(); ?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
<tr class="info"><td> 点数入力画面 </td></tr>
<tr><td> 一問一答画面 </td></tr>
<tr><td> 模擬試験画面 </td></tr>
<?= $this->end(); ?>

<!-- 以下content -->
<div class = "container-fluid">
    <!--header-->
    <div class = "row">
        <div class = col-md-12>
            <div id= "qaa-title">
                一問一答
            </div>
            <div id = "qaa-sub">
                ジャンル選択
            </div>
        </div>
    </div>

    <div class = "row">
        <div class = "col-md-12">
            <!--explanation-->
            <p id="qaa-explanation">
                試験ジャンルを設定すると、一問一答形式で対応ジャンルの設問が出題されます。<br>
                [詳細]を押すことで現在の総合回答数とジャンル別の正答率を確認することができます。<br>
                なお、一問一答での回答結果は結果一覧には登録されません。<br>
            </p>
        </div>
    </div>

    <div class= "row">
        <div class = "col-md-12">
            <div class= "genre-container">
                <!--select genre-->
                <div class = "caption-box">
                    <!--枠線の上に重ねる文字-->
                    <div class = "caption"><p>ジャンル一覧</p></div>
                    <!--form-->
                    <?= $this -> Form -> create
                            ('',
                            ['type' => 'get',
                            'url' => ['action' => 'qaa_question']])?>
                    <label class="checkbox">
                    <?= $this -> Form -> checkbox("SelectGenre.check1",array('data-toggle' => "checkbox",'class'=> 'genre')) ?>テクノロジ <br>
                    </label>
                    <label class="checkbox">
                    <?= $this -> Form -> checkbox("SelectGenre.check2",array('data-toggle' => "checkbox",'class'=> 'genre')) ?>ストラテジ <br>
                    </label>
                    <label class="checkbox">
                    <?= $this -> Form -> checkbox("SelectGenre.check3",array('data-toggle' => "checkbox",'class'=> 'genre')) ?>マネジメント
                    </label>
                </div>
                <!--決定ボタン-->
                <div class = "center">
                    <?php
                    echo $this -> Form -> button('問題開始',array('type' => 'submit','class' => 'btn btn-info'));
                    echo $this -> Form -> end();
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
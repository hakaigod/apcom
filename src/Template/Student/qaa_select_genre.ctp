<!-- タイトルセット -->
<?= $this->start('title'); ?>
管理者メニュー
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/qaa_select_ganre.css') ?>
<?= $this->end(); ?>

<!-- jsセット -->
<?= $this->start('script'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
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
        <div class = "col-md-8">
            <!--explanation-->

        </div>
    </div>

</div>

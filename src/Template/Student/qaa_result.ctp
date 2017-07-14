<?php
/**
 * 一問一答終了後に回答一覧を表示する
 */
?>

<!-- タイトルセット -->
<?= $this->start('title');?>
一問一答結果
<?= $this->end();?>
<!-- CSSセット -->
<?= $this->start('css');?>
<?= $this->Html->css('/private/css/Student/qaa.css')?>
<?= $this->end();?>

<!-- ユーザーネームセット -->
<?= $this->start('username');?>
Student
<?= $this->end();?>
<!-- jsセット -->
<?= $this->start('script');?>
<?= $this->Html->script('/private/js/Student/getlog.js')?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js')?>
<?= $this->end();?>
<!-- 以下content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div id= "qaa-title">
                一問一答
            </div>
            <div id="qaa-sub">
                回答結果
            </div>
        </div>
    </div>
    <table class="table table-bordered" id="log-table">
        <thead>
        <tr>
            <th>回答番数</th>
            <th>問題番号</th>
            <th>出典</th>
            <th>ジャンル</th>
            <th>正誤</th>
        </tr>
        </thead>
    </table>
</div>
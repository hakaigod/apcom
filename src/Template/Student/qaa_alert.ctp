<?php
/**
 *urlへの入力でのページ遷移などで選択ジャンルがPOSTされていない場合にはこの画面へ遷移する
 * 5秒後にジャンル選択画面へ遷移させる
 */
?>

<!-- タイトルセット -->
<?= $this->start('title');?>
一問一答エラー
<?= $this->end();?>
<!-- CSSセット -->
<?= $this->start('css');?>
<?= $this->Html->css('/private/css/Student/qaa.css')?>
<?= $this->end();?>
<!-- jsセット -->
<?= $this->start('script');?>
<script id="script" src="<?= $this->request->getAttribute('webroot'); ?>/private/js/Student/interval.js"
        webroot="<?= $this->request->getAttribute('webroot'); ?>/student/qaaSelectGenre";
></script>
<?= $this->end();?>
<!-- ユーザーネームセット -->
<?= $this->start('username');?>
Student
<?= $this->end();?>

<div class="alert alert-danger" id="qaa-alert" role="alert">
    <!--警告文字-->
    <div class="row">
        問題の取得に失敗しました。<span id="countdown">5</span> 秒後にジャンル選択に移動します。<br>
        <u><?= $this->Html->link('ここ',
            [
                'action'=>'qaaSelectGenre'
            ])
        ?></u>
        をクリックすると直ちに移動します。
    </div>
</div>
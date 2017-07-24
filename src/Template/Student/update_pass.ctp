
<?php
/**
 * @var \App\View\AppView $this
 * @var string $userID
 * @var string $username
 * @var string $studentName
 * @var string $studentID
 * @var string $role
 * @var array $logoLink
 */
?>

<!-- タイトルセット -->
<?php $this->start('title'); ?>
応用情報ど.com  -パスワード更新
<?php $this->end(); ?>

<!-- CSSセット -->
<?php $this->start('css'); ?>
<?php $this->end(); ?>


<?php $this->start('script'); ?>
<?= $this->Html->script('/private/js/Student/displayPass.js') ?>
<?= $this->Html->script('/private/js/Student/verifyPass.js') ?>
<?php $this->end();?>

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
<?php foreach($hamMenu as $hamName => $hamLink):?>
    <tr><td><?= $this->Html->link($hamName,$hamLink)?></td></tr>
<?php endforeach; ?>
<?php $this->end(); ?>

<?= $this->Flash->render();?>
<br>
<div class="col-md-offset-3 col-md-6">
    <h5>パスワード変更</h5>
    ログインに使用するパスワードを変更できます。<br>
    パスワードを共有することや、推測されやすいパスワードは避けてください。
</div>

<div class="col-md-offset-3 col-md-6">
        <form name="http://localhost:27780/apcom/student/updatePassword" action="updatePassword" method="post" id="change-pass">
            <br>
            現在のパスワード
            <input type="password" name="old-pass" id="old-pass" class="form-control pass-form" placeholder="現在のパスワード"
                   required pattern="^([a-zA-Z0-9]{8,20})$">
            <div id="old-pass-text"></div>

            <br>
            新しいパスワード
            <input type="password" name="new-pass" id="new-pass" class="form-control pass-form newer" placeholder="新しいパスワード"
                   required pattern="^([a-zA-Z0-9]{8,20})$">
            <div id="new-pass-text"></div>

            <br>
            再入力
            <input type="password" name="verify" id="verify" class="form-control newer" placeholder="再入力"
                   required pattern="^([a-zA-Z0-9]{8,20})$">
            <button type="button" id="show-pass" class="btn btn-xs btn-info">パスワード表示</button>
            <div id="verify-text"></div>
            <br>
            <div class="full buttons">
                <button type="button" onclick="history.back()" class="col-xs-5 btn btn-warning">キャンセル</button>
                <button type="button" id="register-button"  class="col-xs-offset-2 col-xs-5 btn btn-success">登録</button>
            </div>
        </form>
    </div>

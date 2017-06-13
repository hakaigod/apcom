
<!-- jsセット -->
<?= $this->start('script'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?= $this->end(); ?>

<!-- ユーザーネームセット -->
<?= $this->start('username');
echo $name->stuname;
$this->end();
?>

<!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request->webroot ?>/Student">トップページ</a></td></tr>
<tr><td><a href="">パスワード更新</a></td></tr>
<?= $this->end(); ?>

<?php
foreach ($answers as $answer): ?>
    <tr>
        <td><?= $answer->imicode ?></td>
        <td><?= $answer->qesnum ?></td>
    </tr>
    <br>
<?php endforeach; ?>
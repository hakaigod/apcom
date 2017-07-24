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

<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><?= $this->Html->link('トップページ',$logoLink)?></td></tr>
<tr><td><?= $this->Html->link('過去問題演習',["action" => "yearSelection"])?></td></tr>
<tr><td><?= $this->Html->link('一問一答',["action" => "qaaSelectGenre"])?></td></tr>
<tr><td><?= $this->Html->link('パスワード更新',["action" => "updatePass"])?></td></tr>
<?php $this->end(); ?>
<br>

<!-- jsセット -->
<?php function json_safe_encode($data){
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}?>
<?= $this->start('script');?>
<script id="script" src = "<?= $this->request->getAttribute('webroot'); ?>/private/js/Student/setpagination.js"
        pgNum = '<?= json_safe_encode($pgNum); ?>'
        server-addr = '<?= json_safe_encode($_SERVER['SERVER_ADDR']); ?>'
        server-port = '<?= json_safe_encode($_SERVER['SERVER_PORT']); ?>'
></script>
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
            <th>出典</th>
            <th>ジャンル</th>
            <th>正誤</th>
        </tr>
        </thead>
    </table>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <!-- ここに出題番号 出典を表示  -->
                        <div id="question-title"></div>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" id="result-contents">
                        <!-- 問題を表示 -->
                        <div id="question-sentence"></div>
                        <!--選択肢が画像の場合に表示 -->
                        <div id="qaa-answerpic"></div>
                        <!-- 選択肢を表示 -->
                        <table class="table table-bordered table-striped" id="result-table">
                            <tr>
                                <td>ア</td>
                                <td><div id="question-choice1"></div></td>
                            </tr>
                            <tr>
                                <td>イ</td>
                                <td><div id="question-choice2"></div></td>
                            </tr>
                            <tr>
                                <td>ウ</td>
                                <td><div id="question-choice3"></div></td>
                            </tr>
                            <tr>
                                <td>エ</td>
                                <td><div id="question-choice4"></div></td>
                            </tr>
                        </table>
                        <div id="log-yourans"></div>
                        <div id="log-ans"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success full" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ページネーター -->
    <div class="col-md-12">
        <div class="row">
            <ul class="pagination-plain">
                <li id="pagination-number">
                    <form method="post" id="form-pgnation">
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="return-selectgenre">
                <?= $this->HTML->Link('ジャンル選択に戻る',['class'=>'button','action'=>'qaaSelectGenre'])?>
            </div>
        </div>
    </div>
</div>

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
<?php function json_safe_encode($data){
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}?>
<?= $this->start('script');?>
<script id="script" src="<?= $this->request->getAttribute('webroot') ;?>/private/js/Student/setpagination.js"
        qgNum = '<?= json_safe_encode($qgNum); ?>'
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
            <th>問題番号</th>
            <th>出典</th>
            <th>ジャンル</th>
            <th>正誤</th>
        </tr>
        </thead>
    </table>
    <!--ページネーション-->
    <div id="qaa-pagination">
        <ul class="pagination">
            <!--ページ番号初期に戻る矢印の設定-->
            <li class="previous" id="qaa-previous">
                <a href="#" class="fui-arrow-left"></a>
            </li>
            <!--ページネーション番号の設定 ログの数によって番号数を増減する-->
            <!-- Make dropdown appear above pagination -->
            <li class="pagination-dropdown dropup">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fui-triangle-up"></i>
                </a>
                <!--ページを一気に移動する矢印の設定-->
                <!-- Dropdown menu -->
                <ul class="dropdown-menu">
                    <!--10刻みで指定して番号に移動するドロップダウンメニュー-->
                    <li>
                        <!--問題番号の数で表示する項目数を変更する-->
                        <a href="#">11-20</a>
                        <a href="#">21-30</a>
                        <a href="#">31-40</a>
                    </li>
                </ul>
            </li>

            <li class="next">
                <a href="#" class="fui-arrow-right"></a>
            </li>
        </ul>
    </div>

</div>
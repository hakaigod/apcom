<?php
/**
 * 問題テーブル
 * @var \App\Model\Entity\MfQe $question
 * 問題とページ番号　新しい問題に遷移する度インクリメント
 * @var Integer $qNum
 * @var array $getGenre
 */
?>
<!-- タイトルセット -->
<?= $this->start('title'); ?>
一問一答
<?= $this->end(); ?>

<!-- CSSセット -->
<?= $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/qaa.css') ?>
<?= $this->end(); ?>

<!-- jsセット -->
<?= $this->start('script'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?= $this->Html->script('/private/js/Student/qaa.js') ?>
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
    <div class = "row">
        <div class = "col-md-12">
            <div class = col-md-12>
                <div id = "qaa-title">
                    一問一答
                </div>
                <div id = "qaa-detail">
                    [<a onclick = " " data-toggle = "modal" data-target = "#myModal"> 詳細 </a>]
                </div>
                <!--モーダルウィンドウの中身 -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">一問一答  現在の成績</h4>
                            </div>
                            <div class="modal-body">Modal内容</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">閉じる</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--ここから出題問題表示-->
    <div class = "row">
        <div class = "col-md-12">
            <div id = "qaa-question-no">
                問：
                <?php
                if($qNum > 1) {
                    echo $qNum;
                } else {
                    echo 1;}
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class = "qaa-question">
                <!--問題文-->
                <div>
                    <?=  $question -> question ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id = "qaa-falsehood">
                <br><!-- ○か☓の画像表示 -->
            </div>
        </div>
    </div>
    <!--選択肢-->
    <div class="qaa-select-answer">
        <!--選択肢ア-->
        <div class="row row-eq-height">
            <div class="col-md-1">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "ア" onclick = "SelectAns(1)">
            </div>
            <div class="col-md-11">
                        <span class="select-choice">
                            <?= $question -> choice1 ?>
                        </span>
            </div>
        </div>
        <!--選択肢イ-->
        <div class="row row-eq-height">
            <div class="col-md-1">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "イ" onclick = "SelectAns(2)">
            </div>
            <div class="col-md-11">
                        <span class="select-choice">
                            <?= $question -> choice2 ?>
                        </span>
            </div>
        </div>
        <!--選択肢ウ-->
        <div class="row row-eq-height">
            <div class="col-md-1">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "ウ" onclick = "SelectAns(3)">
            </div>
            <div class="col-md-11">
                        <span class="select-choice">
                            <?= $question -> choice3 ?>
            </div>
        </div>
        <!--選択肢エ-->
        <div class="row row-eq-height">
            <div class="col-md-1">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "エ" onclick = "SelectAns(4)">
            </div>
            <div class="col-md-11">
                        <span class="select-choice">
                            <?= $question -> choice4 ?>
                        </span>
            </div>
        </div>
    </div>
    <!--送信ボタン-->
    <div class="col-md-12">
        <div class="row">
            <div class = "qaa-next">
                <form action = "" method="post">
                    <?= $this->Form->button('次の問題', ['type' => 'submit', 'class' => 'btn btn-warning','value' => $qNum,'formaction' => $qNum + 1]) ?>
                    <input type = "hidden" name = "genre[0]" value = "<?= $getGenre["0"] ?>" >
                    <input type = "hidden" name = "genre[1]" value = "<?= $getGenre["1"] ?>" >
                    <input type = "hidden" name = "genre[2]" value = "<?= $getGenre["2"] ?>" >
                </form>
            </div>
        </div>
    </div>
</div>
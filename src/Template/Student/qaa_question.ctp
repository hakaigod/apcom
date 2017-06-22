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
<?= $this->Html->script('/private/js/Student/cnt_qu_no.js') ?>
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
        <div class = "col-md-12">
            <div class = col-md-12>
                <div id = "qaa-title">
                    一問一答
                </div>
                <div id = "qaa-detail">
                    [<a onclick = " " data-toggle = "modal" data-target = "#myModal"> 詳細 </a>]
                </div>

                <!-- モーダルウィンドウの中身 -->
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
            問：<!-- 問題番号 -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class = "qaa-question">
                <!--問題文-->
                <?php foreach ($questions as $question): ?>
                    <div>
                        <?=  ($question -> question) ?>
                    </div>
                <?php endforeach; ?>
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

    <div class="qaa-select-answer">
        <div class="row">
            <div class="col-md-12">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "ア" onclick = "SelectAns(1)">
                <div class="select-a">
                    <?php foreach ($choices as $choice): ?>
                        <?= ($choice -> choice1) ?>
                    <?php endforeach; ?>
                </div>
                <input type = "button" class = "btn btn-embossed btn-primary" value = "イ" onclick = "SelectAns(2)">
                <div class="select-a">
                    <?php foreach ($choices as $choice): ?>
                        <?= ($choice -> choice2) ?> <br>
                    <?php endforeach; ?>
                </div>
                <input type = "button" class = "btn btn-embossed btn-primary" value = "ウ" onclick = "SelectAns(3)">
                <div class="select-a">
                    <?php foreach ($choices as $choice): ?>
                        <?= ($choice -> choice3) ?>
                    <?php endforeach; ?>
                </div>
                <input type = "button" class = "btn btn-embossed btn-primary" value = "エ" onclick = "SelectAns(4)">
                <div class="select-a">
                    <?php foreach ($choices as $choice): ?>
                        <?= ($choice -> choice4) ?> <br>
                    <?php endforeach; ?> <br>
                </div>
            </div>
        </div>
    </div>
    <div class=""></div>

    <div class = "qaa-next">
        <?= $this -> Form -> create(null,['type' => 'post','url' => ['action' => '']]) ?>
        <?= $this -> Form -> submit('次の問題',
                ['type' => 'submit',
                'class' => 'btn btn-warning',
                'formaction' => '']) ?>
        <?= $this -> Form -> end(); ?>
    </div>
</div>


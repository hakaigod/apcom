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
                <!--ここに問題番号を表示-->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class = "qaa-question">
                問題の文章か画像の表示
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
                <input type = "button" class = "btn btn-embossed btn-primary" value = "A" onclick = "SelectAns(1)">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "B" onclick = "SelectAns(2)">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "C" onclick = "SelectAns(3)">
                <input type = "button" class = "btn btn-embossed btn-primary" value = "D" onclick = "SelectAns(4)">
            </div>
        </div>
    </div>
    <div class=""></div>

    <div class = "qaa-next">
        <?= $this -> Form -> create(null,['type' => 'get','url' => ['action' => 'qaa-question']]) ?>
        <?= $this -> Form -> submit("次の問題",array('type' => 'submit',  'class' => 'btn btn-warning','name' => 'cnt')) ?>
        <?= $this -> Form -> end(); ?>
    </div>
</div>
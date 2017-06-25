<?php
/**
 * @var \App\Model\Entity\MfQe $question
 */
?>

<!--問題表示画面-->



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
<?= $this->Html->script('/private/js/Student/check.js') ?>
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

<!--                                 モーダルウィンドウの中身 -->
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
<!--        ここから出題問題表示-->
    <div class = "row">
        <div class = "col-md-12">
            <div id = "qaa-question-no">
                問：
                <!--                --><?php //$num ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class = "qaa-question">
                <!--                問題文-->
                <div>
                    <?=  $question->question ?>
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

    <div class="col-md-12">
        <div class="qaa-select-answer">
            <div class="row">
                <ul style="list-style:none;">
                    <li>
                        <input type = "button" class = "btn btn-embossed btn-primary" value = "ア" onclick = "SelectAns(1)">
                        <span class="select-choice">
                            <?= $question->choice1 ?>
                        </span>
                    </li>
                    <li>
                        <input type = "button" class = "btn btn-embossed btn-primary" value = "イ" onclick = "SelectAns(2)">
                        <span class="select-choice">
                            <?= $question->choice2 ?>
                </span>
                    </li>
                    <li>
                        <input type = "button" class = "btn btn-embossed btn-primary" value = "ウ" onclick = "SelectAns(3)">
                        <span class="select-choice">
                            <?= $question->choice3 ?>
                        </span>
                    </li>
                    <li>
                        <input type = "button" class = "btn btn-embossed btn-primary" value = "エ" onclick = "SelectAns(4)">
                        <span class="select-choice">
                            <?= $question->choice4 ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class = "qaa-next">
                <?php
                echo $this->Form->create(null, ['type' => 'post', 'url' => ['action' => '']]);
                echo $this->Form->submit('次の問題',
                    ['type' => 'submit',
                        'class' => 'btn btn-warning',
                        'formaction' => ''
                    ]);
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>


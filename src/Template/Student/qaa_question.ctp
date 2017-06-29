<?php
/**
 * 問題とページ番号　新しい問題に遷移する度インクリメント
 * @var Integer $qNum
 * @var array $getGenre
 */
?>

<!-- タイトルセット -->
<?= $this->start('title');?>
一問一答
<?= $this->end();?>

<!-- CSSセット -->
<?= $this->start('css');?>
<?= $this->Html->css('/private/css/Student/qaa.css')?>
<?= $this->end();?>

<!-- jsセット -->
<?php function json_safe_encode($data){
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}
?>

<?= $this->start('script');?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js')?>
<script id="script" src="<?= $this->request->getAttribute('webroot')?>/private/js/Student/qaa.js"
    answer=<?= json_safe_encode($question->answer)?>
></script>
<?= $this->end();?>

<!-- ユーザーネームセット -->
<?= $this->start('username');?>
Student
<?= $this->end();?>

<!-- サイドバーセット -->
<?= $this->start('sidebar');?>
<tr class="info"><td> 点数入力画面 </td></tr>
<tr><td> 一問一答画面 </td></tr>
<tr><td> 模擬試験画面 </td></tr>
<?= $this->end();?>

<!-- 以下content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class=col-md-12>
                <div id="qaa-title">
                    一問一答
                </div>
                <div id="qaa-detail">
                    [<a onclick=" " data-toggle="modal" data-target="#myModal"> 詳細 </a>]
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
    <!--出典表示-->
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="Source">

                </div>
            </div>
        </div>
    </div>
    <!--出題問題表示-->
    <div class="row">
        <div class="col-md-12">
            <div id="qaa-question-no">
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
            <div class="qaa-question">
                <!--問題文-->
                <div>
                    <?= $this->qaa->viewTextImg($question->question)?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="qaa-falsehood">
                <br><!-- ○か☓の画像表示 -->
            </div>
        </div>
    </div>
    <!--選択肢ある場合-->
    <?php if(!empty($question->choice1)):?>
    <!--選択肢-->
    <table class="qaa_select_table table-bordered col-md-12">
        <tr class="select_tr" >
            <td class="col-md-1">
                <input type="button" id="choice" class="btn btn-embossed btn-primary full" value="ア" onclick="selectAnswer(1)">
            </td>
            <td class="col-md-11">
                <?= $this->qaa->viewTextImg($question->choice1)?>
            </td>
        </tr>
        <tr>
            <td class="col-md-1">
                <input type="button" class="btn btn-embossed btn-primary full" value="イ" onclick="selectAnswer(2)">
            </td>
            <td class="col-md-11">
                <?= $this->qaa->viewTextImg($question->choice2)?>
            </td>
        </tr>
        <tr>
            <td class="col-md-1">
                <input type="button" class="btn btn-embossed btn-primary full" value="ウ" onclick="selectAnswer(3)">
            </td>
            <td class="col-md-11">
                <?= $this->qaa->viewTextImg($question->choice3)?>
            </td>
        </tr>
        <tr>
            <td class="col-md-1">
                <input type="button" class="btn btn-embossed btn-primary full" value="エ" onclick="selectAnswer(4)">
            </td>
            <td class="col-md-11">
                <?= $this->qaa->viewTextImg($question->choice4)?>
            </td>
        </tr>
    </table>
    <!--選択肢がない場合は該当する画像があるのでそれを取ってきて文字なしのチェックボックスを拾ってくる-->
    <?php else:?>
        <!--画像無し選択肢-->
        <!-- 画像表示 -->
        <div class=row>
            <div class="ans-img col-md-12">
                <?= $this->qaa->viewTextImg($question->answer_pic)?>
            </div>
        </div>
        <div class="row">
            <div class="select-answer">
                <input type="submit" class="btn btn-embossed btn-primary" value="1" >
                <input type="submit" class="btn btn-embossed btn-primary" value="2" >
                <input type="submit" class="btn btn-embossed btn-primary" value="3" >
                <input type="submit" class="btn btn-embossed btn-primary" value="4" >
            </div>
        </div>
    <?php endif;?>
    <!--送信ボタン-->
    <div class="col-md-12">
        <div class="row">
            <div class="qaa-next">
                <form action="" method="post">
                    <?= $this->Form->button('次の問題', ['type'=>'submit', 'class'=>'btn btn-warning','value'=>$qNum,'formaction'=>$qNum + 1])?>
                    <input type="hidden" name="genre[0]" value="<?= $getGenre[0]?>" >
                </form>
            </div>
        </div>
    </div>
</div>
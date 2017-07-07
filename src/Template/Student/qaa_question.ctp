<?php
/**
 * 問番号
 * @var Integer $qNum
 *
 * DBから取得した１行の問情報
 * @var array $question
 *
 * 選択肢番号
 * @var Integer $select
 *
 * 前問題の正誤、選択、問題情報を格納する配列
 * @var array $answerLog
 *
 * ジャンル選択画面からPOSTしたジャンル番号
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
<?= $this->Html->script('/private/js/Student/getlog.js')?>
<script id="script" src = "<?= $this->request->getAttribute('webroot'); ?>/private/js/Student/setlog.js"
        qnum = '<?= json_safe_encode($qNum); ?>'
        answer = '<?= json_safe_encode($question->answer); ?>'
        field = '<?= json_safe_encode($question->mf_fie['fiename']); ?>'
        detail = '<?= json_safe_encode($question->mf_exa->exam_detail); ?>'
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
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div id= "test1"></div>
                                </div>
                            </div>
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
                <div class="source">
                    出典：<?= $question->mf_exa->exam_detail . " 問" . $question->qesnum?>
                </div>
            </div>
        </div>
    </div>
    <!--出題問題表示-->
    <div class="row">
        <div class="col-md-12">
            <div id="qaa-question-no">
                問：
                <?= $qNum?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="qaa-question">
                <!--問題文-->
                <div>
                    <!-- ヘルパー使用 -->
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
            <?php for($i=1;$i<5;$i++):?>
                <?php $selectArray = array('ア','イ','ウ','エ')?>
                <tr class="select_tr" >
                    <td class="col-md-1">
                        <input type="button" class="choice btn btn-embossed btn-primary full" value=<?php $select=$i?><?= $selectArray[$i-1] ?>>
                    </td>
                    <td class="col-md-11">
                        <?php
                        $choice = 'choice'.$i;
                        echo $this->qaa->viewTextImg($question->$choice);
                        ?>
                    </td>
                </tr>
            <?php endfor; ?>
        </table>
    <?php else:?>
        <!--選択肢がない場合は該当する画像があるので文章無しのボタン表示-->
        <div class=row>
            <div class="ans-img col-md-12">
                <?= $this->qaa->viewTextImg($question->answer_pic)?>
            </div>
        </div>
        <div class="row">
            <div class="select-answer">
                <?php for ($i=1;$i<5;$i++):?>
                    <?php $selectArray = array('ア','イ','ウ','エ')?>
                    <input type="submit" class="choice btn btn-embossed btn-primary" value=<?php $select=$i?><?= $selectArray[$i-1] ?> >
                <?php endfor; ?>
            </div>
        </div>
    <?php endif;?>
    <!--送信ボタン-->
    <div class="col-md-12">
        <div class="row">
            <div class="qaa-next">
                <form action="" method="post">
                    <?= $this->Form->button('次の問題', ['type'=>'submit', 'class'=>'btn btn-warning','value'=>$qNum,'formaction'=>$qNum + 1])?>
                    <input type="hidden" name="genre[0]" value="<?= $getGenre[0]?>">
                    </form>
            </div>
        </div>
    </div>
</div>
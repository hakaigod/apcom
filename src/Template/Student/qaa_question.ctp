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
        quesnum = '<?= json_safe_encode($question->qesnum); ?>'
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
                <?php if($qNum != 1):?>
                    <div id="qaa-detail">
                        [<a onclick=" " data-toggle="modal" data-target="#myModal"> 詳細 </a>]
                    </div>
                <?php else:?>
                    <div id="qaa-detail">
                        <strike>[ 詳細 ]</strike>
                    </div>
                <?php endif;?>
                <!--モーダルウィンドウの中身 -->
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">現在の成績</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <!--累計情報-->
                                    <div class="row" id="technology-topic">
                                        <div class="col-md-3">
                                            <div style="font-size:16px;">テクノロジ:</div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="progress" id="progress-technology">
                                                <!--プログレスバー表示-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  id="management-topic">
                                        <div class="col-md-3">
                                            <div style="font-size:16px">マネジメント：</div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="progress" id="progress-management">
                                                <!--プログレスバー表示-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="strategy-topic">
                                        <div class="col-md-3">
                                            <div style="font-size:16px">ストラテジ：</div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="progress" id="progress-strategy">
                                                <!--プログレスバー表示-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--過去問題ログ-->
                                        <table id="log-table" class="table table-bordered">
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
                                    </div>
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
                    出典：<?= $question->mf_exa->exam_detail ." 問" .$question->qesnum ."  " .$question->mf_fie->fiename ?>
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
        <table class="qaa_select_table table-bordered col-md-12" id="choice-table">
            <?php for($i=1;$i<5;$i++):?>
                <?php $selectArray = array('ア','イ','ウ','エ')?>
                <tr class="select_tr" >
                    <td class="col-md-1">
                        <input type="button" class="choice btn btn-embossed btn-primary full" id="choice<?= $i?>" value=<?php $select=$i?><?= $selectArray[$i-1] ?>>
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
    <div class="col-md-12">
        <div class="row" id="btn-row">
            <ul>
                <li>
                    <div class="qaa-complete">
                        <form action="" method="post">
                        <!--一問一答終了ボタン-->
                            <a href= "<?= $this->url->build(['action'=>'qaaResult','pagination_num'=>1])?>" class="btn btn-danger">終了する</a>
                    </div>
                </li>
                <li>
                    <div class="qaa-next">
                        <!--送信ボタン-->
                        <form action="" method="post">
                            <?= $this->Form->button('次の問題', ['type'=>'submit', 'class'=>'btn btn-warning','id'=>'qaa-next-btn', 'value'=>$qNum,'formaction'=>$qNum + 1])?>
                            <?php for($i=0;$i<count($getGenre);$i++):?>
                                <input type="hidden" name="genre[]" value="<?= $getGenre[$i]?>">
                            <?php endfor;?>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
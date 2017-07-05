<?php
/**
 * 問番号
 * @var Integer $qNum
 * DBから取得した１行の問情報
 * @var array $question
 * 選択肢番号
 * @var Integer $select
 * 前問題の正誤、選択、問題情報を格納する配列
 * @var array $answerLog
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
                            <div class="modal-body">
                                <div class="container-fluid">


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
                    <input type="submit" class="choice btn btn-embossed btn-primary" value=<?php $select=$i?><?= $selectArray[$i-1]?> >
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
                    <!--セッションへの保存-->
                    <input type="hidden" name="answerLog" value="
                    <?php
                    //falsehoodに正誤又は未回答の結果を入力
                    if($question->answer == $select){
                        $falsehood = "O";
                    }else if($select == ""){
                        $falsehood = "-";
                    }else {
                        $falsehood = "X";
                    }

                    if (empty($answerLog['$qNum'])){
                        $answerLog = array(
                            '$qNum'=>array(
                                'qnum'=>$qNum,
                                'detail'=>$question->mf_exa->exam_detail,
                                'field'=>$question->mf_fie->fiename,
                                'falsehood'=>$falsehood
                            )
                        );
                    } else {
                        $answerLog = array_merge($answerLog,
                            array(
                                '$qNum'=>array(
                                    'qnum'=>$qNum,
                                    'detail'=>$question->mf_exa->exam_detail,
                                    'field'=>$question->mf_fie->fiename,
                                    'falsehood'=>$falsehood
                                )
                            )
                        );
                    }
                    $i = 0;
                    foreach ($answerLog as $list=>$num){
                        echo ($num);
                        foreach ($num as $item=>$value){
                            echo $item.'=>'.$value('qnum');
                            echo $item.'=>'.$value('detail');
                            echo $item.'=>'.$value('field');
                            echo $item.'=>'.$value('falsehood');
                        }
                    }

                    $list = array(
                        '山田' => array(
                            'ID' => '001',
                            '出身' => '函館',
                            'メールアドレス' => 'yamada@example.com',
                            '性別' => '女性'
                        ),
                        '田中' => array(
                            'ID' => '002',
                            'メールアドレス' => 'tanaka@example.com',
                            '性別'  => '男性'
                        ),
                        '高橋' => array(
                            'ID' => '003',
                            '出身' => '札幌',
                            'メールアドレス' => 'takahasi@example.com',
                            '性別'  => '女性',
                        ),
                        '井上' => array(
                            'ID' => '004',
                            '出身' => '東京',
                            'メールアドレス' => 'inoue@example.com',
                            '性別'  => '男性',
                        ),
                        '小林' => array(
                            'ID' => '005',
                            '出身' => '大阪',
                            'メールアドレス' => 'kobayasi@example.com',
                            '性別'  => '男性',
                        ),
                        '森' => array(
                            'ID' => '006',
                            '出身' => '沖縄',
                            'メールアドレス' => 'mori@example.com',
                            '性別'  => '女性',
                        )
                    );

                    $i = 0;
                    //配列の中の名前を出す。
                    foreach($list as $key => $member){
                        echo $key;
                        if($i < count($list)-1){
                            echo ',';
                        }
                        $i++;
                    }

                    //改行。
                    echo PHP_EOL;

                    //配列の中の名前を出す。
                    echo join(",",array_keys($list)).PHP_EOL;


                    //出身地札幌の人間を表示する
                    foreach($list as $key => $member){
                        if(!isset($member['出身']) || $member['出身'] != '札幌'){
                            echo $key.PHP_EOL;
                        }
                    }

                    ?>">
                </form>
            </div>
        </div>
    </div>
</div>
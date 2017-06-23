<?php
/**
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MfExa[] $exams
 * @var array $averages
 */
?>

<!-- タイトルセット -->
<?php $this->start('title'); ?>
試験年度選択
<?php $this->end(); ?>


<!-- CSSセット -->
<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Student/yearSelection.css') ?>
<?php $this->end(); ?>


<!-- jsセット -->
<?php $this->start('script'); ?>
<?php $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?php $this->end(); ?>


<!-- ユーザーネームセット -->
<?php $this->start('username'); ?>
managerrrrr
<?php $this->end(); ?>


<!-- サイドバーセット -->
<?php $this->start('sidebar'); ?>
<tr class="info"><td><a>トップページ</a></td></tr>
<tr><td><a>一問一答</a></td></tr>
<tr><td><a>結果閲覧</a></td></tr>
<tr><td><a>点数入力</a></td></tr>
<tr><td><a>設定</a></td></tr>
<?php $this->end(); ?>


<div>

    <!-- header -->
    <h1 class="exam-title">模擬試験</h1>
    <p class="message">過去の午前問題が解けます。<br/>
        受けたい試験の年度を選択してください。
    </p>


    <!-- テーブル   -->

    <div class="yearBox">
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered ful">
                    <!--                   <colgroup style="background-color: #66afe9;" span="1"></colgroup>-->
                    <thead id="tableTitle">
                    <tr><th>試験年度</th><th>受験回数</th><th>前回の点数</th><th>全体の平均点</th></tr>
                    </thead>
                    <tbody>

                    <!--   行の要素   -->
                    <tr>
                        <?php $i = 0; foreach($exams as $exam): ?>
                        <td>
                            <div class="btn btn-info full">
                            <?= $this->Html->link("平成".$exam->jap_year . "年度 ". $exam->exaname ,
                                [
                                    'action'=>'practiceExam',
                                ])
                             ?>
                            </div>
                        </td>
                        <td>0</td>
                        <td>76</td>

                        <td><?= $averages[$exam->exanum]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br/><br/>

<button id="d" type="button">

    <?= $this->Html->link("TOPへ戻る" ,
        [
            'action'=>'',
        ])
    ?>
</button>

<!-- タイトルセット -->
<?= $this->start('title'); ?>
    試験年度選択
<?= $this->end(); ?>


    <!-- CSSセット -->
<?= $this->start('css'); ?>
	<?= $this->Html->css('/private/css/Student/yearSelection.css') ?>
<?= $this->end(); ?>


    <!-- jsセット -->
<?= $this->start('script'); ?>
	<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js') ?>
<?= $this->end(); ?>


    <!-- ユーザーネームセット -->
<?= $this->start('username'); ?>
    managerrrrr
<?= $this->end(); ?>


    <!-- サイドバーセット -->
<?= $this->start('sidebar'); ?>
    <tr class="info"><td><a>トップページ</a></td></tr>
    <tr><td><a>一問一答</a></td></tr>
    <tr><td><a>結果閲覧</a></td></tr>
    <tr><td><a>点数入力</a></td></tr>
    <tr><td><a>設定</a></td></tr>
<?= $this->end(); ?>


<div>

    <!-- header -->
    <hi class="exam-title">模擬試験</hi>
    <p class="message">過去の午前問題が解けます。<br/>
    </p>

<!--    <form method="post" class="radio">-->
<!--         <input type="radio" name="Annual" value="h29h" disabled><a id="year">平成29年度 秋 午前</a>-->
<!--        <input type="radio" name="Annual" value="h29h"><a id="year">平成29年度 春 午前</a><br/>-->
<!--        <input type="radio" name="Annual" value="h28a"><a id="year">平成28年度 秋 午前</a>-->
<!--        <input type="radio" name="Annual" value="h28h"><a id="year">平成28年度 春 午前</a><br/>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成27年度 秋 午前</a>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成27年度 春 午前</a><br/>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成26年度 秋 午前</a>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成26年度 春 午前</a><br/>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成25年度 秋 午前</a>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成25年度 春 午前</a><br/>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成24年度 秋 午前</a>-->
<!--        <input type="radio" name="Annual" value="h27a"><a id="year">平成24年度 春 午前</a><br/>-->
<!--    </form>-->


    <?php $i = 0; foreach($exams as $exam): ?>
            <input class="radio" type="radio" name="Annual" value="">
            <div id="year" class="col-lg--4" ><?= $exam->exaname; ?></div>
            <?php $i++; ?>
            <?php if($i % 2==0): ?>
               <br/>
            <?php endif; ?>
    <?php endforeach; ?>


    <?php
        if(isset($_POST["frm"])&&(isset($_POST["Annual"]))){
            header("practice_exam.ctp");
         }
    ?>

    <form name="frm" method="post" action="" class="ok">
            <input type="button" onclick="location.href='practice_exam.ctp'" value="決定" />
    </form>



</div>




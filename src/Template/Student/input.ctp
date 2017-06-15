<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') ?>
<?= $this->Html->script('video.js') ?>
<?= $this->Html->script('flat-ui.min.js') ?>
<?= $this->Html->css('bootstrap.min.css') ?>
<?= $this->Html->css('flat-ui.css') ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>

<form action="" method="post">
<table class="table table-bordered table-striped table-hover">
	<?= $this->Html->tableHeaders(['問題番号', '解答','自信度']); ?>
	<?php for ($i = 1; $i <= 10; $i++ ): ?>
		<tr>
			<td><?= $i ?></td>
			<td>
                <div data-toggle="buttons">
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off"> ア
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off"> イ
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off"> ウ
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off"> エ
                    </label>
                    <label class="btn btn-info active">
                        <input type="radio" autocomplete="off" checked> 未記入
                    </label>
                </div>
            </td>
			<td>
                <div data-toggle="buttons">
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off"> o
                    </label>
                    <label class="btn btn-info active">
                        <input type="radio" autocomplete="off" checked> △
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" autocomplete="off"> x
                    </label>
                </div>
			</td>
		</tr>
	<?php endfor; ?>
</table>

</form>
<br><br><br><br><br><br><br><br>
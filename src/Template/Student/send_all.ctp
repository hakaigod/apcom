<?php
/**
 *
 * @var \App\View\AppView $this
 * @var string $userID
 * @var bool $answeredAll
 * @var bool $result
 * @var int $imicode
 * @var bool $imicodeInRange
 */
use App\Controller\StudentController;

?>

<?php $this->start('css'); ?>
<?= $this->Html->css('/private/css/Input/input.css') ?>
<?php $this->end(); ?>

<?php $this->start('sidebar'); ?>
<tr class="info"><td><a href="<?= $this->request-> getAttribute('webroot') ?>/Manager">トップページ</a></td></tr>
<tr><td><a href="manager/strmanager">学生情報管理</a></td></tr>
<?php $this->end(); ?>
<br>
<?php
$title = '自動的にページが移動しない場合はこちらをクリックしてください';
$link = null;
$linkArray = [
	'controller' => 'student',
	'id'         => $userID];
if ($answeredAll) {
	if ($imicodeInRange) {
		if ( $result ) {
			$link = $this->Html->link($title,$linkArray + ['action' => 'result' ,'imicode'    => $imicode]);
		} else {
			echo '解答の送信に失敗しました。時間を置いて再度お試しください。';
			$link = $this->Html->link($title, $linkArray + ['action' => 'summary']);
		}
	}else{
		echo '実施されていない模擬試験です。';
		$link = $this->Html->link($title, $linkArray + ['action' => 'summary']);
	}
} else{
	echo 'すべての解答が入力されていません。';
	$link = $this->Html->link($title, $linkArray + [ 'action'     => 'input', 'imicode'    => $imicode, 'linkNum'   => 1 ]);
}
?>

<br>
<?= $link;?>
<br>
<br>

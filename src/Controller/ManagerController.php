<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use \Exception;

class ManagerController extends AppController
{
	public function initialize(){
		parent::initialize();
		$this->set('headerlink', $this->request->webroot . 'Manager');
		$this->loadmodel('MfDep');
		$this->loadmodel('MfStu');
		$this->loadmodel('MfAdm');
		$this->loadmodel('TfSum');
		$this->loadmodel('TfAns');
		$this->loadmodel('MfExa');
		$this->loadmodel('TfImi');
	}

	// マネージャートップ画面
	public function index()
	{
		//フィルタ　試験一覧・模擬試験一覧
		$this->set('year', $this->MfExa->find('all'));
		$this->set('imiexas', $this->TfImi->find()->select(['imicode'])->order(['imicode']));

		// 受験済み学生表示用
		$query = $this->TfSum->find()->contain(['MfStu']);
		$query ->order(['TfSum.regnum' => 'DESC'])
		->where(['imicode' => 2]);
		$this->set('students', $query);

		// 受験者平均点
		$queryAvg = $this->TfSum->find();
		$queryAvg ->select(['average' => $queryAvg->func()->avg('imisum')])->where(['imicode' => 2]);
		$aveArr = $queryAvg->toArray();
		$this->set('average', array_shift ($aveArr));

		// 模擬試験ごとの回答データ取得
		$ans = $this->TfAns->find();
		$ans ->select(['imicode', 'regnum', 'qesnum', 'rejoinder'])
		->where(['imicode' => 2])
		->group(['imicode', 'regnum', 'qesnum'])
		->order(['regnum' =>'DESC','qesnum']);

		// 回答データを連想配列に格納
		$answers = array();
		$i=0; $work = null;
		foreach ($ans as $key) {
			switch ($key->rejoinder) {
				case 0: $ansJa = '';break;
				case 1: $ansJa = 'ア';break;
				case 2: $ansJa = 'イ';break;
				case 3: $ansJa = 'ウ';break;
				default: $ansJa = 'エ';break;
			}
			if ($work == $key->regnum) {
				$answers[$key->regnum] += array('ans'. $i++ => $ansJa);
			} else {
				$answers += array($key->regnum => array('ans'. $i++ => $ansJa));
			}
			$work = $key->regnum;
		}
		$this->set('answers', $answers);

		// 模擬試験一覧
		$imidata = $this->TfImi->find()->contain(['MfExa'])->order(['TfImi.exanum', 'imp_date']);
		$arrayimis = array();$work = null;
		foreach ($imidata as $key) {
			$exam = '平成' . $key->mf_exa->jap_year . '年' . $key->mf_exa->exaname;
			if($key->exanum == $work) {
				$arrayimis += array($key->imicode => array('name' => $exam , 'num' => ++$i, 'imipepnum' => $key->imipepnum, 'imisum' => $key->imisum));
			} else {
				$i = 0;
				$arrayimis += array($key->imicode => array('name' => $exam , 'num' => ++$i, 'imipepnum' => $key->imipepnum, 'imisum' => $key->imisum));
			}
			$work = $key->exanum;
		}
		$this->set('imidata', $arrayimis);
	}

	// 学生管理
	public function strmanager()
	{
		// 学科一覧
		$this->set('deps', $this->MfDep->find());

		// 学生一覧
		$query = $this->MfStu->find()->contain(['MfDep']);
		$query ->order(['regnum' => 'DESC']);

		// where
		if (!empty($_POST)) {
			if (!empty($_POST['regnum'])) {
				$query -> where(['regnum' => $this->request->data('regnum')]);
			} else {
				if (!empty($_POST['admname'])) {
					$query -> where(['admname LIKE' => '%'.$_POST['admname'].'%']);
				}
				if ($_POST['depnum'] != '0'){
					$query -> where(['MfStu.depnum' => $_POST['depnum']]);
				}
				if ($_POST['stuyear'] != '0') {
					$query -> where(['stuyear' => $_POST['stuyear']]);
				}
				if (empty($_POST['deleted_flg'])) {
					$query -> where(['MfStu.deleted_flg' => FALSE]);
				}
				if (empty($_POST['graduate_flg'])) {
					$query -> where(['graduate_flg' => FALSE]);
				}
			}
		} else {
			$query -> where(['MfStu.deleted_flg' => FALSE]);
			$query -> where(['graduate_flg' => FALSE]);
		}

		// $query ;
		$this->set('records', $query);
	}
	public function addstr()
	{
		$this->viewBuilder()->layout('addmod');

		$this->set('deps', $this->MfDep->find());
		if (!empty($_POST)) {
			$query = $this->MfStu->query();
			$query->insert(['regnum', 'stuname', 'stuyear', 'depnum', 'stupass']);
			$query->values([
				'regnum' => $_POST['strno'],
				'stuname' => $_POST['strname'],
				'stuyear' => $_POST['old'],
				'depnum' => $_POST['depnum'],
				'stupass' => ''
			]);
			try {
				$query->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing');
			}
		}
	}
	public function modstr()
	{
		$this->viewBuilder()->layout('addmod');

		// 学生情報
		try {
			$this->set('regnum', $this->MfStu->get($_GET['id']));
		} catch (Exception $e) {
			// 学籍番号更新後、画面更新せずに編集ボタンを押した場合エラーが起きる
			die('Student Not Found.');
		}

		// 学科一覧
		$this->set('deps', $this->MfDep->find());

		if (!empty($_POST)) {
			$query = $this->MfStu->query();
			$query->update();
			$query->set([
				'regnum' => $_POST['strno'],
				'stuname' => $_POST['strname'],
				'stuyear' => $_POST['old'],
				'depnum' => $_POST['depnum'],
				'deleted_flg' => !empty($_POST['deleted_flg']),
				'graduate_flg' => !empty($_POST['graduate_flg'])
			]);
			$query->where(['regnum' => $_GET['id']]);
			try {
				$query->execute();
				$this->redirect('/Manager/modstr?id='.$_POST['strno']);
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing');
				$this->set('regnum', $this->MfStu->get($_GET['id']));
			}
		}
	}

	// 管理者管理
	public function adminmanager()
	{
		// 管理者一覧
		$query = $this->MfAdm->find();
		// where
		if (!empty($_POST)) {
			if (!empty($_POST['admnum'])) {
				$query -> where(['admnum' => $this->request->data('admnum')]);
			} else {
				if (!empty($_POST['admname'])) {
					$query -> where(['admname LIKE' => '%'.$_POST['admname'].'%']);
				}
				if (empty($_POST['deleted_flg'])) {
					$query -> where(['deleted_flg' => FALSE]);
				}
			}
		} else {
			$query -> where(['deleted_flg' => FALSE]);
		}

		$this->set('admins', $query);
	}
	public function addadmin()
	{
		$this->viewBuilder()->layout('addmod');

		if (!empty($_POST)) {
			$query = $this->MfAdm->query();
			$query->insert(['admnum', 'admname', 'admpass']);
			$query->values([
				'admnum' => NULL,
				'admname' => $_POST['admname'],
				'admpass' => ''
			]);
			try {
				$query->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing');
			}
		}
	}
	public function modadmin()
	{
		$this->viewBuilder()->layout('addmod');

		// 管理者情報
		$this->set('admnum', $this->MfAdm->get($_GET['id']));

		if (!empty($_POST)) {
			$query = $this->MfAdm->query();
			$query->update();
			$query->set([
				'admname' => $_POST['admname'],
				'deleted_flg' => !empty($_POST['deleted_flg'])
			]);
			$query->where(['admnum' => $_GET['id']]);
			try {
				$query->execute();
				$this->redirect('/Manager/modadmin?id='.$_POST['admno']);
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing');
				$this->set('admnum', $this->MfAdm->get($_GET['id']));
			}
		}
	}

	public function imiCodeIssue() {
		$this->viewBuilder()->layout('addmod');

		$this->set('exams', $this->MfExa->find());

	}

}

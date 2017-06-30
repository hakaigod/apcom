<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use \Exception;
use \SplFileObject;
use App\Utils\ImageGeneratorUtility;

class ManagerController extends AppController
{
	public function initialize(){
		parent::initialize();
		$this->set('headerlink', $this->request->webroot . 'Manager');

		$this->loadComponent('Paginator');
		$this->loadComponent("Identicon");

		$this->loadmodel('MfDep');
		$this->loadmodel('MfStu');
		$this->loadmodel('MfAdm');
		$this->loadmodel('TfSum');
		$this->loadmodel('TfAns');
		$this->loadmodel('MfExa');
		$this->loadmodel('TfImi');
		$this->loadmodel('MfQes');
	}
	// ページネーター
	public $paginate = [
		'order' => ['TfAns.qesnum']
	];

	// パスワードハッシュ値返却
	private function passhash($pass){
		$hasher = new DefaultPasswordHasher();
		return $hasher->hash($pass);
	}
	private function passcheck($inputPass, $databasePass) {
		$hasher = new DefaultPasswordHasher();
		return $hasher->check($inputPass, $databasePass);
	}

	// マネージャートップ画面
	public function index()
	{
		$query = $this->TfImi->find();
		$nearimi = $query->select(['max' => $query->func()->max('imicode')])->first()->toArray()['max'];
		//直近の模擬コード取得
		if (!empty($_GET['id'])) {
			$reqestimicode = $_GET['id'];
		} else {
			$reqestimicode = $nearimi;
		}

		// 受験者平均点
		$queryAvg = $this->TfImi->find();
		$queryAvg ->select(['imisum' => 'strategy_imisum + technology_imisum + management_imisum', 'imipepnum'])->where(['imicode' => $reqestimicode]);
		$aveArr = $queryAvg->toArray();
		$this->set('average', array_shift($aveArr));

		// 模擬試験ごとの回答データ取得
		$cnt = $this->TfSum->find()->where(['imicode' => $reqestimicode]);

		$ans = $this->TfAns->find()->contain(['MfStu']);
		$ans ->where(['imicode' => $reqestimicode])
		->group(['imicode', 'qesnum', 'TfAns.regnum'])
		->order(['qesnum', 'TfAns.regnum' =>'DESC']);
		$ans->limit(($cnt->count() * 10));
		if (!empty($_GET['page'])) {
			$ans ->offset($_GET['page'] * 10 - 10);
		}
		// ページネーターセット
		$this->paginate['limit'] = $cnt->count() * 10;
		$this->paginate($ans);

		// 回答データを連想配列に格納
		$answers = array();
		$work = null;
		$i = 0;
		foreach ($ans as $key) {
			switch ($key->rejoinder) {
				case 0: $ansJa = '';break;
				case 1: $ansJa = 'ア';break;
				case 2: $ansJa = 'イ';break;
				case 3: $ansJa = 'ウ';break;
				default: $ansJa = 'エ';break;
			}
			if(isset($answers[$key->regnum])){
				$answers[$key->regnum]['answers'] += array('ans'. $i++ => $ansJa);
			} else {
				$query = $this->TfSum->get([$key->regnum, $reqestimicode]);
				$answers += array($key->regnum => array('regnum' => $key->regnum, 'stuname' =>$key->mf_stu['stuname'],  'imisum' => $query->strategy_sum + $query->technology_sum + $query->management_sum, 'answers'=> array('ans'. $i++ => $ansJa)));
			}
		}
		$this->set('answers', $answers);

		// 正答率
		$pars = array();
		$corrects = array();
		$i = 0;
		foreach ($ans as $key) {
			if(isset($pars[$key->qesnum])){
				$pars[$key->qesnum]['answers'] += array('ans'. $i++ => $key->rejoinder);
			} else {
				$pars += array($key->qesnum => array('qesnum' => $key->qesnum, 'correct_answer' => $key->correct_answer, 'answers'=> array('ans'. $i++ => $key->rejoinder)));
			}
		}
		foreach ($pars as $key) {
			$corrects += array($key['qesnum'] => array('qesnum' => $key['qesnum'], 'corrects' => 0, 'question' => ''));
			foreach ($key['answers'] as $value) {
				if($value == $key['correct_answer']){
					$corrects[$key['qesnum']]['corrects'] += 1;
				}
			}
		}
		foreach ($corrects as $key) {
			$corrects[$key['qesnum']]['corrects'] /= $cnt->count();
		}

		$questions = $this->MfQes->find();
		$exanum = $this->TfImi->find()->select('exanum')->where(['imicode' => $reqestimicode]);
		$questions ->select(['exanum', 'qesnum', 'question'])
		->where(['exanum' => $exanum]);
		if (!empty($_GET['page'])) {
			$questions ->offset($_GET['page'] * 10 - 10);
		}
		$questions ->order(['qesnum'])->limit(10);
		$this->set('questions', $questions);

		$questionsdetail = array();
		foreach ($questions as $key) {
			$questionsdetail += array($key['qesnum'] => array('exanum' => $key['exanum'], 'qesnum' => $key['qesnum'], 'corrects' => 0, 'question' => $key['question']));
		}

		if (!empty($corrects)) {
			foreach ($corrects as $key) {
				$questionsdetail[$key['qesnum']]['corrects'] += $key['corrects'];
			}
		}
		$this->set('questionsdetail', $questionsdetail);
		// ここまで正答率

		// 模擬試験一覧
		$imidata = $this->TfImi->find()->contain(['MfExa'])->order(['TfImi.exanum','imicode']);
		$arrayimis = array();
		$work = null;
		// 模擬試験の回数を数える
		foreach ($imidata as $key) {
			$exam = '平成' . $key->mf_exa->jap_year . '年' . $key->mf_exa->exaname;
			if($key->exanum != $work) {
				$i = 0;
			}
			$arrayimis += array($key->imicode => array('imi' => $key->imicode, 'name' => $exam , 'num' => ++$i, 'imipepnum' => $key->imipepnum, 'imisum' => $key->strategy_imisum + $key->technology_imisum + $key->management_imisum));
			$work = $key->exanum;
		}
		array_multisort($arrayimis, SORT_DESC);
		$this->set('imidata', $arrayimis);

		// タイトルセット
		if (empty($_GET['id']) || $_GET['id'] == $nearimi) {
			$this->set('detaiExamName', '直近一回分');
		} else {
			$this->set('detaiExamName', $arrayimis[$reqestimicode]['name'] . ' ' . $arrayimis[$reqestimicode]['num']  . '回目');
		}
	}


	// 問題詳細
	public function questionDetail()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		$this->set('questionDetail', $this->MfQes->get([$_GET['qn'], $_GET['ex']],['contain' => ['MfExa']]));
	}

	// 学生管理
	public function stuManager()
	{
		// 学科一覧
		$this->set('deps', $this->MfDep->find());

		// 学生一覧
		$query = $this->MfStu->find()->contain(['MfDep']);
		$query ->order(['regnum' => 'DESC']);

		// where
		if (!empty($_POST)) {
			if (!empty($_POST['regnum'])) {
				$query -> where(['regnum' => $_POST['regnum']]);
			} else {
				if (!empty($_POST['stuname'])) {
					$query -> where(['stuname LIKE' => '%'.$_POST['stuname'].'%']);
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
	public function addstu()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');
		$identiconComponent = $this->loadComponent("Identicon");

		$this->set('deps', $this->MfDep->find());

		// 個別追加
		if (!empty($_POST)) {
			if (empty($_POST['stuno']) || empty($_POST['stuname'])) {
				// 学生番号か名前が未入力の場合
				$this->Flash->error('missing');
			} else {
				$query = $this->MfStu->query();
				$query->insert(['regnum', 'stuname', 'stuyear', 'depnum', 'stupass']);
				$query->values([
					'regnum' => $_POST['stuno'],
					'stuname' => $_POST['stuname'],
					'stuyear' => $_POST['old'],
					'depnum' => $_POST['depnum'],
					'stupass' => $this->passhash($_POST['stuno'])
				]);

				try {
					$query->execute();
					$identiconComponent->makeImage($_POST['stuno']);
					$this->Flash->success('success');
				} catch (Exception $e) {
					$this->Flash->error('missing' . $e->getMessage());
				}
			}

		}
		// 一括追加
		if (!empty($_FILES)) {
			if ($_FILES["studata"]["name"] == 'addstu') {
				// 読み込んだSJISのデータをUTF-8に変換して保存
				file_put_contents($_FILES["studata"]["tmp_name"], mb_convert_encoding(file_get_contents($_FILES["studata"]["tmp_name"]), 'UTF-8', 'SJIS'));
				// UTF-8に変換したデータをSplFileObjectでCSVとして読み込み
				$file = new SplFileObject($_FILES["studata"]["tmp_name"]);
				$file->setFlags(SplFileObject::READ_CSV);
				// 配列に格納
				foreach ($file as $line) {
					$records[] = $line;
				}

				$querystu = $this->MfStu->query();
				$querystu->insert(['regnum', 'stuname', 'stuyear', 'depnum', 'stupass']);

				foreach ($records as $key) {
					if (!empty($key[0]) && $key[0] != '学籍番号'){
						$querydep = $this->MfDep->find();
						$depnum = $querydep ->select('depnum')->where(['depname LIKE' => '%' . $key[2] . '%']);

						$querystu->values([
							'regnum' => $key[0],
							'stuname' => $key[1],
							'stuyear' => $key[3],
							'depnum' => $depnum,
							'stupass' => $this->passhash($key[0])
						]);
					}
				}
				try {
					$querystu->execute();
					$this->Flash->success('success');
				} catch (Exception $e) {
					$this->Flash->error('missing ' . $e->getMessage());
				}
			} else {
				$this->Flash->error('専用テンプレートを使用してください');
			}
		}
	}

	public function modstu()
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

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			if (empty($_POST['stuno']) || empty($_POST['stuname'])) {
				// 学生番号か名前が未入力の場合
				$this->Flash->error('missing');
			} else {
				$queryStuUpdate = $this->MfStu->query();
				$queryStuUpdate->update();
				$queryStuUpdate->set([
					'regnum' => $_POST['stuno'],
					'stuname' => $_POST['stuname'],
					'stuyear' => $_POST['old'],
					'depnum' => $_POST['depnum'],
					'deleted_flg' => !empty($_POST['deleted_flg']),
					'graduate_flg' => !empty($_POST['graduate_flg'])
				]);
				$queryStuUpdate->where(['regnum' => $_GET['id']]);
				try {
					$queryStuUpdate->execute();
					// 学籍番号が変更されたら、画像の名前を変更
					if ($_POST['stuno'] != $_GET['id']) {
						rename('private/img/identicons/' . $_GET['id'] . '.png', 'private/img/identicons/' . $_POST['stuno'] . '.png');
					}

					$this->redirect(['controller' => 'Manager', 'action' => 'modstu?id=' .$_POST['stuno']]);
					$this->Flash->success('success');
				} catch (Exception $e) {
					$this->Flash->error('missing ' . $e->getMessage());
					$this->set('regnum', $this->MfStu->get($_GET['id']));
				}
			}
		}
	}

	// 管理者管理
	public function adminManager()
	{
		// 管理者一覧
		$query = $this->MfAdm->find();
		// where
		if (!empty($_POST)) {
			if (!empty($_POST['admnum'])) {
				$query -> where(['admnum' => $_POST['admnum']]);
			} else {
				if (!empty($_POST['admname'])) {
					$query -> where(['admname LIKE' => '%' . $_POST['admname'] . '%']);
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
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');
		$identiconComponent = $this->loadComponent("Identicon");

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			if (empty($_POST['admname']) || empty($_POST['admpass'])) {
				// 学生番号か名前が未入力の場合
				$this->Flash->error('missing');
			} else {
				$query = $this->MfAdm->query();
				$query->insert(['admnum', 'admname', 'admpass']);
				$query->values([
					'admnum' => NULL,
					'admname' => $_POST['admname'],
					'admpass' => $this->passhash($_POST['admpass'])
				]);
				try {
					$query->execute();
					$admnum = $this->MfAdm->find()->select('admnum')->where(['admname like' => '%' . $_POST['admname'] . '%'])->first()->toArray()['admnum'];
					$identiconComponent->makeImage($admnum);
					$this->Flash->success('success');
				} catch (Exception $e) {
					$this->Flash->error('missing ' . $e->getMessage());
				}
			}
		}
	}
	public function modadmin()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		// 管理者情報
		$this->set('admnum', $this->MfAdm->get($_GET['id']));

		// POSTリクエストがあれば実行
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
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
				$this->set('admnum', $this->MfAdm->get($_GET['id']));
			}
		}
	}
	// 管理者パスワード再設定
	public function resetAdmPass()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			$oldPass = $this->MfAdm->get($_POST['admnum'])->toArray()['admpass'];
			if ($this->passcheck($_POST['admOldPass'], $oldPass)) {
				$admPassUpdate = $this->MfAdm->query()->update();
				$admPassUpdate->set(['admpass' => $this->passhash($_POST['admNewPass'])])
				->where(['admnum' => $_POST['admnum']]);
				try {
					$admPassUpdate->execute();
					$this->Flash->success('success');
				} catch (Exception $e) {
					$this->Flash->error('missing ' . $e->getMessage());
				}
			} else {
				$this->Flash->error('古いパスワードが違います');
			}
		}
	}


	// 模擬試験コード発行画面
	public function imiCodeIssue()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		$this->set('exams', $this->MfExa->find());

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			$query = $this->TfImi->query();
			$query->insert(['imicode', 'exanum']);
			$query->values([
				'imicode' => NULL,
				'exanum' => $_POST['exanum']
			]);
			try {
				$query->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
			}
		}
	}
	// 学生パスワード再発行画面
	public function reIssueStuPass()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		// POSTリクエストがあれば実行
		if (!empty($_POST['stuno'])) {
			$query = $this->MfStu->query();
			$query->update();
			$query->set(['stupass' => $this->passhash($_POST['stuno'])])
			->where(['regnum' => $_POST['stuno']]);
			try {
				$query->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
			}
		}
	}
	// 学科管理画面
	public function depManager() {
		$query = $this->MfDep->find();
		// where
		if (!empty($_POST)) {
			if (!empty($_POST['depnum'])) {
				$query -> where(['depnum' => $_POST['depnum']]);
			} else {
				if (!empty($_POST['admname'])) {
					$query -> where(['admname LIKE' => '%' . $_POST['depnum'] . '%']);
				}
				if (empty($_POST['deleted_flg'])) {
					$query -> where(['deleted_flg' => FALSE]);
				}
			}
		} else {
			$query -> where(['deleted_flg' => FALSE]);
		}

		$this->set('deps', $query);
	}

	public function adddep()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			$query = $this->MfDep->query();
			$query->insert(['depnum', 'depname']);
			$query->values([
				'depnum' => NULL,
				'depname' => $_POST['depname']
			]);
			try {
				$query->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
			}
		}
	}
	public function moddep()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		// 学科情報
		$this->set('dep', $this->MfDep->get($_GET['id']));

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			$query = $this->MfDep->query()->update();
			$query->set([
				'depname' => $_POST['depname'],
				'deleted_flg' => !empty($_POST['deleted_flg'])
			])
			->where(['depnum' => $_POST['depnum']]);
			try {
				$query->execute();
				//直前のページにリダイレクト
				$this->redirect($this->referer());
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
				$this->redirect($this->referer());
			}
		}
	}
}

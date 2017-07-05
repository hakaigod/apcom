<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

// use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use \Exception;
use \SplFileObject;

class ManagerController extends AppController
{
	public function initialize(){
		parent::initialize();

		$this->set("logoLink", ["controller" => "manager","action" => "index"]);
		
		$this->loadComponent('Paginator');

		$this->loadmodel('MfDep');
		$this->loadmodel('MfStu');
		$this->loadmodel('MfAdm');
		$this->loadmodel('TfSum');
		$this->loadmodel('TfAns');
		$this->loadmodel('MfExa');
		$this->loadmodel('TfImi');
		$this->loadmodel('MfQes');
		
		$session = $this->request->session();
		$this->set("username",$session->read("username"));
		
		$this->set("userID",$session->read("userID"));
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
	// パスワードチェック
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
		$queryAvg = $this->TfImi->find()
		->select(['imisum' => 'strategy_imisum + technology_imisum + management_imisum', 'imipepnum'])
		->where(['imicode' => $reqestimicode])->first()->toArray();
		// 模擬試験の受験員人数
		$imipepnum = $queryAvg['imipepnum'];
		$avg = 0;
		if ($imipepnum != 0) {
			$avg = $queryAvg['imisum'] / $queryAvg['imipepnum'];
		}
		$this->set('average', $avg);

		// 模擬試験ごとの回答データ取得
		$ans = $this->TfAns->find()->contain(['MfStu'])
		->where(['imicode' => $reqestimicode])
		->group(['imicode', 'qesnum', 'TfAns.regnum'])
		->order(['qesnum', 'TfAns.regnum' =>'DESC'])
		->limit(($imipepnum * 10));
		if (!empty($_GET['page'])) {
			$ans->offset($_GET['page'] * 10 - 10);
		}
		// ページネーターセット
		$this->paginate['limit'] = $imipepnum * 10;
		$this->paginate($ans);

		// 回答データを連想配列に格納
		$answers = array();
		$work = null;
		$i = 0;
		$ansJa = ['', 'ア', 'イ', 'ウ', 'エ'];
		foreach ($ans as $key) {
			if(isset($answers[$key->regnum])){
				$answers[$key->regnum]['answers'] += array('ans'. $i++ => $ansJa[$key->rejoinder]);
			} else {
				$query = $this->TfSum->get([$key->regnum, $reqestimicode]);
				$answers += array($key->regnum => array('regnum' => $key->regnum, 'stuname' =>$key->mf_stu['stuname'],  'imisum' => $query->strategy_sum + $query->technology_sum + $query->management_sum, 'answers'=> array('ans'. $i++ => $ansJa[$key->rejoinder])));
			}
		}
		$this->set('answers', $answers);

		// 問題情報取得
		$questions = $this->MfQes->find();
		$exanum = $this->TfImi->find()->select('exanum')->where(['imicode' => $reqestimicode])->first()->toArray()['exanum'];
		$questions->select(['exanum', 'qesnum', 'question', 'answer'])
		->where(['exanum' => $exanum]);
		if (!empty($_GET['page'])) {
			$questions->offset($_GET['page'] * 10 - 10);
		}
		$questions->order(['qesnum'])->limit(10);
		$this->set('questions', $questions);

		// 正答率
		$questionsDetail = array();
		foreach ($questions as $key) {
			// 問分の連想配列を準備
			$questionsDetail += array($key['qesnum'] => array('exanum' => $key['exanum'], 'qesnum' => $key['qesnum'], 'question' => $key['question'], 'corrects' => 0, 'correct_answer' => $key->answer, 'answers'=> array()));
		}
		$i = 0;
		foreach ($ans as $key) {
			$questionsDetail[$key->qesnum]['answers'] += array('ans'. $i++ => $key->rejoinder);
		}
		foreach ($questionsDetail as $key) {
			foreach ($key['answers'] as $value) {
				if($value == $key['correct_answer']){
					// 正答数をカウント
					$questionsDetail[$key['qesnum']]['corrects'] += 1;
				}
			}
		}
		if ($imipepnum != 0) {
			foreach ($questionsDetail as $key) {
				// 正答率に変換
				$questionsDetail[$key['qesnum']]['corrects'] /= $imipepnum;
			}
		}
		$this->set('questionsdetail', $questionsDetail);
		// ここまで正答率

		// 模擬試験一覧
		$imidata = $this->TfImi->find()->contain(['MfExa'])->order(['TfImi.exanum','imicode']);
		$arrayimis = array();
		$work = null;
		// 模擬試験の回数を数える
		foreach ($imidata as $key) {
			if($key->exanum != $work) {
				$i = 0;
			}
			$exam = $key->mf_exa->exam_detail;
			$arrayimis += array($key->imicode => array('imi' => $key->imicode, 'name' => $exam , 'num' => ++$i, 'imipepnum' => $key->imipepnum, 'imisum' => $key->strategy_imisum + $key->technology_imisum + $key->management_imisum));
			$work = $key->exanum;
		}
		array_multisort($arrayimis, SORT_DESC);
		$this->set('imidata', $arrayimis);

		// タイトルセット
		if (empty($_GET['id']) || $_GET['id'] == $nearimi) {
			$this->set('detailExamName', '直近一回分');
		} else {
			$this->set('detailExamName', $arrayimis[$reqestimicode]['name'] . ' ' . $arrayimis[$reqestimicode]['num']  . '回目');
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
		$this->set('deps', $this->MfDep->find()->where(['deleted_flg' => FALSE]));

		// 学生一覧
		$queryStudens = $this->MfStu->find()->contain(['MfDep'])
		->order(['regnum' => 'DESC']);

		// where
		if (!empty($_POST)) {
			if (!empty($_POST['regnum'])) {
				$queryStudens->where(['regnum' => $_POST['regnum']]);
			} else {
				if (!empty($_POST['stuname'])) {
					$queryStudens->where(['stuname LIKE' => '%'.$_POST['stuname'].'%']);
				}
				if ($_POST['depnum'] != '0'){
					$queryStudens->where(['MfStu.depnum' => $_POST['depnum']]);
				}
				if ($_POST['stuyear'] != '0') {
					$queryStudens->where(['stuyear' => $_POST['stuyear']]);
				}
				if (empty($_POST['deleted_flg'])) {
					$queryStudens->where(['MfStu.deleted_flg' => FALSE]);
				}
				if (empty($_POST['graduate_flg'])) {
					$queryStudens->where(['graduate_flg' => FALSE]);
				}
			}
		} else {
			$queryStudens->where(['MfStu.deleted_flg' => FALSE]);
			$queryStudens->where(['graduate_flg' => FALSE]);
		}

		$this->set('records', $queryStudens);
	}
	public function addstu()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');
		$identiconComponent = $this->loadComponent("Identicon");

		$this->set('deps', $this->MfDep->find()->where(['deleted_flg' => FALSE]));

		// 個別追加
		if (!empty($_POST)) {
			$queryAddStu = $this->MfStu->query()
			->insert(['regnum', 'stuname', 'stuyear', 'depnum', 'stupass'])
			->values([
				'regnum' => $_POST['stunum'],
				'stuname' => $_POST['stuname'],
				'stuyear' => $_POST['old'],
				'depnum' => $_POST['depnum'],
				'stupass' => $this->passhash($_POST['stunum'])
			]);
			try {
				$queryAddStu->execute();
				$identiconComponent->makeImage($_POST['stunum']);
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing' . $e->getMessage());
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
						$depnum = $querydep->select('depnum')->where(['depname LIKE' => '%' . $key[2] . '%']);

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
		$this->set('deps', $this->MfDep->find()->where(['deleted_flg' => FALSE]));

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			$queryStuUpdate = $this->MfStu->query()->update()
			->set([
				'regnum' => $_POST['stunum'],
				'stuname' => $_POST['stuname'],
				'stuyear' => $_POST['old'],
				'depnum' => $_POST['depnum'],
				'deleted_flg' => !empty($_POST['deleted_flg']),
				'graduate_flg' => !empty($_POST['graduate_flg'])
			])
			->where(['regnum' => $_GET['id']]);
			try {
				$queryStuUpdate->execute();
				if ($_POST['stunum'] != $_GET['id']) {
					// 学籍番号が変更されたら、画像の名前を変更
					rename('private/img/identicons/' . $_GET['id'] . '.png', 'private/img/identicons/' . $_POST['stunum'] . '.png');
				}
				$this->redirect(['controller' => 'Manager', 'action' => 'modstu' ,'id' => $_POST['stunum']]);
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
				$this->set('regnum', $this->MfStu->get($_GET['id']));
			}
		}
	}

	// 管理者管理
	public function adminManager()
	{
		// 管理者一覧
		$queryAdmins = $this->MfAdm->find();
		// where
		if (!empty($_POST)) {
			if (!empty($_POST['admnum'])) {
				$queryAdmins->where(['admnum' => $_POST['admnum']]);
			} else {
				if (!empty($_POST['admname'])) {
					$queryAdmins->where(['admname LIKE' => '%' . $_POST['admname'] . '%']);
				}
				if (empty($_POST['deleted_flg'])) {
					$queryAdmins->where(['deleted_flg' => FALSE]);
				}
			}
		} else {
			$queryAdmins->where(['deleted_flg' => FALSE]);
		}

		$this->set('admins', $queryAdmins);
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
				$queryAdminInsert = $this->MfAdm->query()
				->insert(['admnum', 'admname', 'admpass'])
				->values([
					'admnum' => NULL,
					'admname' => $_POST['admname'],
					'admpass' => $this->passhash($_POST['admpass'])
				]);
				try {
					$queryAdminInsert->execute();
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
			$queryAdminUpdate = $this->MfAdm->query()
			->update()
			->set([
				'admname' => $_POST['admname'],
				'deleted_flg' => !empty($_POST['deleted_flg'])
			])
			->where(['admnum' => $_GET['id']]);
			try {
				$queryAdminUpdate->execute();
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
				$queryAdmPassUpdate = $this->MfAdm->query()->update()
				->set(['admpass' => $this->passhash($_POST['admNewPass'])])
				->where(['admnum' => $_POST['admnum']]);
				try {
					$queryAdmPassUpdate->execute();
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
		$this->set('exams', $this->MfExa->find());

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			$queryImiCodeIssueInsert = $this->TfImi->query()
			->insert(['imicode', 'exanum'])
			->values([
				'imicode' => NULL,
				'exanum' => $_POST['exanum']
			]);
			try {
				$queryImiCodeIssueInsert->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
			}
		}
		$this->render('imicodeissue','addmod');
	}
	// 学生パスワード再発行画面
	public function reIssueStuPass()
	{

		// POSTリクエストがあれば実行
		if (!empty($_POST['stunum'])) {
			$queryReIssueStuPassUpdate = $this->MfStu->query()
			->update()
			->set(['stupass' => $this->passhash($_POST['stunum'])])
			->where(['regnum' => $_POST['stunum']]);
			try {
				$queryReIssueStuPassUpdate->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing ' . $e->getMessage());
			}
		}
		
		$this->render('reissuestupass','addmod');
	}
	// 学科管理画面
	public function depManager() {
		$queryDep = $this->MfDep->find();
		// where
		if (!empty($_POST)) {
			if (!empty($_POST['depnum'])) {
				$queryDep->where(['depnum' => $_POST['depnum']]);
			} else {
				if (!empty($_POST['admname'])) {
					$queryDep->where(['admname LIKE' => '%' . $_POST['depnum'] . '%']);
				}
				if (empty($_POST['deleted_flg'])) {
					$queryDep->where(['deleted_flg' => FALSE]);
				}
			}
		} else {
			$queryDep->where(['deleted_flg' => FALSE]);
		}

		$this->set('deps', $queryDep);
	}

	public function adddep()
	{
		// レイアウト設定
		$this->viewBuilder()->layout('addmod');

		// POSTリクエストがあれば実行
		if (!empty($_POST)) {
			$queryDepInsert = $this->MfDep->query()
			->insert(['depnum', 'depname'])
			->values([
				'depnum' => NULL,
				'depname' => $_POST['depname']
			]);
			try {
				$queryDepInsert->execute();
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
			$queryDepUpdate = $this->MfDep->query()->update()
			->set([
				'depname' => $_POST['depname'],
				'deleted_flg' => !empty($_POST['deleted_flg'])
			])
			->where(['depnum' => $_POST['depnum']]);
			try {
				$queryDepUpdate->execute();
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

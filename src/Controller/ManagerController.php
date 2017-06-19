<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class ManagerController extends AppController
{
	public function initialize(){
		parent::initialize();
		// $this->viewBuilder()->layout('default');
		$this->set('headerlink', $this->request->webroot . 'Manager');
	}

	public function index()
	{
	}

	public function strmanager()
	{
		$mf_dep = TableRegistry::get('mf_dep');
		// 学科一覧
		$this->set('deps', $mf_dep->find());

		$mf_stu = TableRegistry::get('mf_stu');
		// 学生一覧
		$query = $mf_stu->find();
		$query
			->select([
				'regnum',
				'stuname',
				'mf_dep.depname',
				'stuyear',
				'graduate_flg',
				'mf_stu.deleted_flg'
			])
			->join([
				'table' => 'mf_dep',
				'type' => 'INNER',
				'conditions' => 'mf_stu.depnum = mf_dep.depnum'
			])
			->order([
				'regnum' => 'DESC'
			]);
		// where
		if (!empty($_POST)) {
			if (!empty($_POST['regnum'])) {
				$query -> where(['regnum' => $this->request->data('regnum')]);
			} else {
				if ($_POST['depnum'] != '0'){
					$query -> where(['mf_stu.depnum' => $_POST['depnum']]);
				}
				if ($_POST['stuyear'] != '0') {
					$query -> where(['stuyear' => $_POST['stuyear']]);
				}
				if (empty($_POST['deleted_flg'])) {
					$query -> where(['mf_stu.deleted_flg' => FALSE]);
				}
				if (empty($_POST['graduate_flg'])) {
					$query -> where(['graduate_flg' => FALSE]);
				}
			}
		} else {
			$query -> where(['mf_stu.deleted_flg' => FALSE]);
			$query -> where(['graduate_flg' => FALSE]);
		}

		// $query ;
		$this->set('records', $query);

		// 在学中学生学年一覧
		$query = $mf_stu->find()
			->select('stuyear')
			->distinct('stuyear');
		$this->set('years', $query);

	}
	public function addstr()
	{
		$this->viewBuilder()->layout('addmod');
	}
	public function modstr()
	{
		$this->viewBuilder()->layout('addmod');

		$mf_stu = TableRegistry::get('mf_stu');
		$mf_dep = TableRegistry::get('mf_dep');
		// 学生情報
		$this->set('regnum', $mf_stu->get($_GET['id']));
		// 学科一覧
		$this->set('deps', $mf_dep->find());

		if (!empty($_POST)) {
			$query = $mf_stu->query();
			$query->update();
			$query->set([
				'regnum' => $_POST['strno'],
				'stuname' => $_POST['strname'],
				'stuyear' => $_POST['old'],
				'depnum' => $_POST['depnum']
			]);
			$query->where(['regnum' => $_GET['id']]);
			try {
				$query->execute();
				$this->Flash->success('success');
			} catch (Exception $e) {
				$this->Flash->error('missing');
			}
		}
	}

	public function adminmanager()
	{
		$mf_adm = TableRegistry::get('mf_adm');
		// 管理者一覧
		$query = $mf_adm->find();
		// where
		if (empty($this->request->data('admnum'))) {
			if ($this->request->data('deleted_flg')) {
				$query -> where(['deleted_flg' => true]);
			} else {
				$query -> where(['deleted_flg' => false]);
			}
		}else{
			$query -> where(['admnum' => $this->request->data('admnum')]);
		}

		$this->set('admins', $query);
	}
	public function modadmin()
	{
		$this->viewBuilder()->layout('addmod');

		$mf_adm = TableRegistry::get('mf_adm');
		$query = $mf_adm->get($_GET['id']);
		$this->set('admnum', $query);
	}
	public function addadmin()
	{
	}

}

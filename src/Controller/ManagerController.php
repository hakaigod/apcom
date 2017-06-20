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
		// $this->viewBuilder()->layout('default');
		$this->set('headerlink', $this->request->webroot . 'Manager');
		$this->loadmodel('MfDep');
		$this->loadmodel('MfStu');
		$this->loadmodel('MfAdm');
	}
	public function depset() {

	}

	public function index()
	{
	}

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
				'stupass' => ""
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
		$this->set('regnum', $this->MfStu->get($_GET['id']));
		// 学科一覧
		$this->set('deps', $this->MfDep->find());

		if (!empty($_POST)) {
			$query = $this->MfStu->query();
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
		// 管理者一覧
		$query = $this->MfAdm->find();
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

		$query = $this->MfAdm->get($_GET['id']);
		$this->set('admnum', $query);
	}
	public function addadmin()
	{
	}

}

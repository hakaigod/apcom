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
		$query = $mf_dep
			->find();
		$this->set('deps', $query);

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
			]);
		// where
		if (empty($this->request->data('regnum'))) {
			if ($this->request->data('deleted_flg')) {
				$query -> where(['mf_stu.deleted_flg' => true]);
			} else {
				$query -> where(['mf_stu.deleted_flg' => false]);
			}
			if ($this->request->data('graduate_flg')) {
				$query -> where(['graduate_flg' => true]);
			} else {
				$query -> where(['graduate_flg' => false]);
			}
		}else{
			// $whereCondition = array('regnum' => null);
			$query -> where(['regnum' => $this->request->data('regnum')]);
		}

		$query
			->order(['regnum' => 'DESC']);

		$this->set('records', $query);

		// 在学中学生学年一覧
		$query = $mf_stu
			->find()
			->select('stuyear')
			->where(['deleted_flg' => false])
			->group('stuyear');
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
		$query = $mf_stu->get($_GET['id']);
		$this->set('regnum', $query);
	}
	public function searchstr()
	{
	}

}

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

		//mf_stuテーブルの読み込み
		$this->loadModel('mf_stu');

		$whereConditions = ['and' => [
				['deleted_flg' => false]
			]
		];
		// $order = (['payment_date' => 'ASC']);

		//SELECTのSQL文オブジェクト
		$sqlObject = $this->mf_stu->find()
			// ->order($order)
			->where($whereConditions);

		//$recordsに検索結果をセットする
		$this->set('records', $sqlObject->all());

	}
	public function addstr()
	{
		$this->viewBuilder()->layout('addmod');
	}
	public function modstr()
	{
		$this->viewBuilder()->layout('addmod');
	}
	public function searchstr()
	{
	}

}

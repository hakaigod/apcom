<?php
namespace App\Model\Table;

use App\Model\Entity\TfImi;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\EntityInterface;

/**
 * TfImi Model
 *
 * @method \App\Model\Entity\TfImi get($primaryKey, $options = [])
 * @method \App\Model\Entity\TfImi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TfImi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TfImi|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TfImi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TfImi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TfImi findOrCreate($search, callable $callback = null, $options = [])
 */
class TfImiTable extends Table
{
	
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config)
	{
		parent::initialize($config);
		
		$this->setTable('tf_imi');
		$this->setDisplayField('imicode');
		$this->setPrimaryKey('imicode');
		//書いた
		$this->belongsTo('MfExa')->setForeignKey('exanum');
	}
	
	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator)
	{
		$validator
			->integer('imicode')
			->allowEmpty('imicode', 'create');
		
		$validator
			->integer('exanum')
			->requirePresence('exanum', 'create')
			->notEmpty('exanum');
		
		$validator
			->numeric('imisum')
			->allowEmpty('imisum');
		
		$validator
			->integer('imipepnum')
			->allowEmpty('imipepnum');
		
		$validator
			->dateTime('imp_date')
			->allowEmpty('imp_date');
		
		return $validator;
	}
	//書いた
	public function getOneAndQes(int $imicode,int $limit = 10,int $page = 1):TfImi{
		$row =  $this->find()
			->contain(['MfExa', 'MfExa.MfQes'=> function ($q) use ($limit, $page) {
					          return $q->select(['exanum','qesnum','question','answer'])
						          ->limit($limit)
						          ->page($page);
				          }
			          ])
			->where(['TfImi.imicode' => $imicode] )
			->first();
		if ($row instanceof TfImi) {
			return $row;
		}else{
			return null;
		}
	}
	//この試験がそれまでに実施された回数 (=何回目か)を取得する
	public function getImplNum(int $imicode,int $exanum) {
		if ( !(isset($imicode)) || !(isset($exanum))) {
			return null;
		}
		return $this->find()
			->where([
				        'TfImi.imicode < ' => $imicode,
				        'TfImi.exanum' => $exanum ])
			->count();
	}
	
}

<?php
namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TfSum Model
 *
 * @method \App\Model\Entity\TfSum get($primaryKey, $options = [])
 * @method \App\Model\Entity\TfSum newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TfSum[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TfSum|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TfSum patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TfSum[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TfSum findOrCreate($search, callable $callback = null, $options = [])
 */
class TfSumTable extends Table
{
	public const TECH_NAME = "technology_sum";
	public const MAN_NAME = "management_sum";
	public const STR_NAME = "strategy_sum";
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('tf_sum');
        $this->setDisplayField('regnum');
        $this->setPrimaryKey(['regnum', 'imicode']);
        //書いた
	    $this->belongsTo('TfImi')->setForeignKey('imicode');
	    $this->belongsTo('MfStu')->setForeignKey('regnum');
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
            ->allowEmpty('regnum', 'create');

        $validator
            ->integer('imicode')
            ->allowEmpty('imicode', 'create');

        $validator
            ->integer('strategy_sum')
            ->requirePresence('strategy_sum', 'create')
            ->notEmpty('strategy_sum');

        $validator
            ->integer('technology_sum')
            ->requirePresence('technology_sum', 'create')
            ->notEmpty('technology_sum');

        $validator
            ->integer('management_sum')
            ->requirePresence('management_sum', 'create')
            ->notEmpty('management_sum');

        return $validator;
    }
    public function getRank(int $imicode, int $sum):int {
    	$result = $this->find()
		    ->select(['upper' => 'count(*)'])
		    ->where(['imicode' => $imicode, 'technology_sum + management_sum + strategy_sum >' => $sum])
		    ->first();
    	return $result->upper + 1;
    }
}

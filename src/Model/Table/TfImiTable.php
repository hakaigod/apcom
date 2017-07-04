<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
            ->integer('strategy_imisum')
            ->requirePresence('strategy_imisum', 'create')
            ->notEmpty('strategy_imisum');

        $validator
            ->integer('technology_imisum')
            ->requirePresence('technology_imisum', 'create')
            ->notEmpty('technology_imisum');

        $validator
            ->integer('management_imisum')
            ->requirePresence('management_imisum', 'create')
            ->notEmpty('management_imisum');

        $validator
            ->integer('imipepnum')
            ->requirePresence('imipepnum', 'create')
            ->notEmpty('imipepnum');

        $validator
            ->dateTime('imp_date')
            ->allowEmpty('imp_date');

        return $validator;
    }
}

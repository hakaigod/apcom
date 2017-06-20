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
            ->dateTime('imp_date')
            ->allowEmpty('imp_date');

        $validator
            ->numeric('imisum')
            ->allowEmpty('imisum');

        $validator
            ->integer('imipepnum')
            ->allowEmpty('imipepnum');

        return $validator;
    }
}

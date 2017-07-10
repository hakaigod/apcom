<?php
namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MfDep Model
 *
 * @method \App\Model\Entity\MfDep get($primaryKey, $options = [])
 * @method \App\Model\Entity\MfDep newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MfDep[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MfDep|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MfDep patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MfDep[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MfDep findOrCreate($search, callable $callback = null, $options = [])
 */
class MfDepTable extends Table
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

        $this->setTable('mf_dep');
        $this->setDisplayField('depnum');
        $this->setPrimaryKey('depnum');
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
            ->integer('depnum')
            ->allowEmpty('depnum', 'create');

        $validator
            ->allowEmpty('depname');

        $validator
            ->boolean('deleted_flg')
            ->requirePresence('deleted_flg', 'create')
            ->notEmpty('deleted_flg');

        return $validator;
    }
}

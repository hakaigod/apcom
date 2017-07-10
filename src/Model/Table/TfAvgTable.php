<?php
namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TfAvg Model
 *
 * @method \App\Model\Entity\TfAvg get($primaryKey, $options = [])
 * @method \App\Model\Entity\TfAvg newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TfAvg[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TfAvg|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TfAvg patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TfAvg[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TfAvg findOrCreate($search, callable $callback = null, $options = [])
 */
class TfAvgTable extends Table
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

        $this->setTable('tf_avg');
        $this->setDisplayField('imicode');
        $this->setPrimaryKey(['imicode', 'exanum']);
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
            ->allowEmpty('exanum', 'create');

        $validator
            ->numeric('imiavg')
            ->allowEmpty('imiavg');

        $validator
            ->dateTime('imp_date')
            ->allowEmpty('imp_date');

        return $validator;
    }
}

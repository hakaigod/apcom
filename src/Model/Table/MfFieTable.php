<?php
namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MfFie Model
 *
 * @method \App\Model\Entity\MfFie get($primaryKey, $options = [])
 * @method \App\Model\Entity\MfFie newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MfFie[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MfFie|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MfFie patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MfFie[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MfFie findOrCreate($search, callable $callback = null, $options = [])
 */
class MfFieTable extends Table
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

        $this->setTable('mf_fie');
        $this->setDisplayField('fienum');
        $this->setPrimaryKey('fienum');
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
            ->allowEmpty('fienum', 'create');

        $validator
            ->allowEmpty('fiename');

        return $validator;
    }
}

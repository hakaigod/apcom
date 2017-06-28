<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MfExa Model
 *
 * @method \App\Model\Entity\MfExa get($primaryKey, $options = [])
 * @method \App\Model\Entity\MfExa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MfExa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MfExa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MfExa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MfExa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MfExa findOrCreate($search, callable $callback = null, $options = [])
 */
class MfExaTable extends Table
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

        $this->setTable('mf_exa');
        $this->setDisplayField('exanum');
        $this->setPrimaryKey('exanum');
        $this->hasMany('MfQes')->setForeignKey('exanum');
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
            ->integer('exanum')
            ->allowEmpty('exanum', 'create');

        $validator
            ->allowEmpty('exaname');

        $validator
            ->dateTime('exa_year')
            ->allowEmpty('exa_year');

        return $validator;
    }
	
}

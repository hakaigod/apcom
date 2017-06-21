<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MfQes Model
 *
 * @method \App\Model\Entity\MfQe get($primaryKey, $options = [])
 * @method \App\Model\Entity\MfQe newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MfQe[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MfQe|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MfQe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MfQe[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MfQe findOrCreate($search, callable $callback = null, $options = [])
 */
class MfQesTable extends Table
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

        $this->setTable('mf_qes');
        $this->setDisplayField('qesnum');
        $this->setPrimaryKey(['qesnum', 'exanum']);
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
            ->allowEmpty('qesnum', 'create');

        $validator
            ->integer('exanum')
            ->allowEmpty('exanum', 'create');

        $validator
            ->requirePresence('fienum', 'create')
            ->notEmpty('fienum');

        $validator
            ->allowEmpty('question');

        $validator
            ->allowEmpty('answer_pic');

        $validator
            ->allowEmpty('choice1');

        $validator
            ->allowEmpty('choice2');

        $validator
            ->allowEmpty('choice3');

        $validator
            ->allowEmpty('choice4');

        $validator
            ->integer('answer')
            ->allowEmpty('answer');

        return $validator;
    }
    public function getTexts($conditions, $mass = 10, $offset = 1){
	    return $this->find()
		    ->select(['qesnum','question'])
		    ->where($conditions)
		    ->limit($mass)
		    ->page($offset);
    }
}

<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TfAns Model
 *
 * @method \App\Model\Entity\TfAn get($primaryKey, $options = [])
 * @method \App\Model\Entity\TfAn newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TfAn[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TfAn|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TfAn patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TfAn[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TfAn findOrCreate($search, callable $callback = null, $options = [])
 */
class TfAnsTable extends Table
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

        $this->setTable('tf_ans');
        $this->setDisplayField('imicode');
        $this->setPrimaryKey(['imicode', 'qesnum', 'regnum']);
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
            ->integer('imicode')
            ->allowEmpty('imicode', 'create');

        $validator
            ->integer('qesnum')
            ->allowEmpty('qesnum', 'create');

        $validator
            ->allowEmpty('regnum', 'create');

        $validator
            ->integer('rejoinder')
            ->allowEmpty('rejoinder');

        $validator
            ->integer('confidence')
            ->allowEmpty('confidence');

        $validator
            ->integer('correct_answer')
            ->allowEmpty('correct_answer');

        return $validator;
    }
}

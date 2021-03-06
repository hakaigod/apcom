<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MfStu Model
 *
 * @method \App\Model\Entity\MfStu get($primaryKey, $options = [])
 * @method \App\Model\Entity\MfStu newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MfStu[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MfStu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MfStu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MfStu[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MfStu findOrCreate($search, callable $callback = null, $options = [])
 */
class MfStuTable extends Table
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

        $this->setTable('mf_stu');
        $this->setDisplayField('regnum');
        $this->setPrimaryKey('regnum');
		$this->belongsTo('MfDep')->setForeignKey('depnum');
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
            ->notEmpty('regnum', '学籍番号が入力されていません。')
            ->lengthBetween('regnum',[8,8],'学籍番号は8文字です。');

        $validator
            ->allowEmpty('stuname');

        $validator
            ->integer('stuyear')
            ->allowEmpty('stuyear');

        $validator
            ->notEmpty('stupass','パスワードが入力されていません。')
            ->lengthBetween('stupass',[4,20],'パスワードは4文字以上20文字未満です。');

        $validator
            ->integer('depnum')
            ->allowEmpty('depnum');

        $validator
            ->dateTime('last_update')
            ->requirePresence('last_update', 'create')
            ->notEmpty('last_update');

        $validator
            ->boolean('graduate_flg')
            ->requirePresence('graduate_flg', 'create')
            ->notEmpty('graduate_flg');

        $validator
            ->boolean('deleted_flg')
            ->requirePresence('deleted_flg', 'create')
            ->notEmpty('deleted_flg');

        return $validator;
    }
    public function findAuth($query, array $options)
    {
        $query->where(['mf_stu.deleted_flg' => 0, 'mf_stu.graduate_flg' => 0]);

        return $query;
    }
}

<?php
namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MfAdm Model
 *
 * @method \App\Model\Entity\MfAdm get($primaryKey, $options = [])
 * @method \App\Model\Entity\MfAdm newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MfAdm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MfAdm|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MfAdm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MfAdm[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MfAdm findOrCreate($search, callable $callback = null, $options = [])
 */
class MfAdmTable extends Table
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

        $this->setTable('mf_adm');
        $this->setDisplayField('admnum');
        $this->setPrimaryKey('admnum');
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
            ->integer('admnum')
            ->notEmpty('admnum', '管理者番号が入力されていません。');

        $validator
            ->allowEmpty('admname');

        $validator
            ->notEmpty('admpass','パスワードが入力されていません。')
            ->lengthBetween('admpass',[8,20],'パスワードは文字以上20文字未満です。');

        $validator
            ->boolean('deleted_flg')
            ->requirePresence('deleted_flg', 'create')
            ->notEmpty('deleted_flg');

        return $validator;
    }
    public function findAuth($query, array $options)
    {
        $query->where(['mf_adm.deleted_flg' => 0]);

        return $query;
    }

}

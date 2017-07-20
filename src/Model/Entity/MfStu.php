<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * MfStu Entity
 *
 * @property string $regnum
 * @property string $stuname
 * @property int $stuyear
 * @property string $stupass
 * @property int $depnum
 * @property \Cake\I18n\FrozenTime $last_update
 * @property bool $graduate_flg
 * @property bool $deleted_flg
 *
 * @property \App\Model\Entity\MfDep $mf_dep
 */
class MfStu extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */


    protected $_accessible = [
        '*' => true,
        'regnum' => false
    ];
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}

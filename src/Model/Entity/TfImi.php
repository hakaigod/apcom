<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TfImi Entity
 *
 * @property int $imicode
 * @property int $exanum
 * @property float $strategy_imisum
 * @property float $technology_imisum
 * @property float $management_imisum
 * @property int $imipepnum
 * @property \Cake\I18n\FrozenTime $imp_date
 *
 * @property \App\Model\Entity\MfExa $mf_exa
 */
class TfImi extends Entity
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
        'imicode' => false
    ];
}

<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TfAn Entity
 *
 * @property int $imicode
 * @property int $qesnum
 * @property string $regnum
 * @property int $rejoinder
 * @property int $confidence
 */
class TfAn extends Entity
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
        'imicode' => false,
        'qesnum' => false,
        'regnum' => false
    ];
}

<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MfQe Entity
 *
 * @property int $qesnum
 * @property int $exanum
 * @property string $fienum
 * @property string $question
 * @property string $answer_pic
 * @property string $choice1
 * @property string $choice2
 * @property string $choice3
 * @property string $choice4
 * @property int $answer
 */
class MfQe extends Entity
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
        'qesnum' => false,
        'exanum' => false
    ];
}

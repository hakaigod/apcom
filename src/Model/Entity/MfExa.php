<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MfExa Entity
 *
 * @property int $exanum
 * @property string $exaname
 * @property \Cake\I18n\FrozenTime $exa_year
 */
class MfExa extends Entity
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
        'exanum' => false
    ];
	public function _getJapYear () {
		return $this->get('exa_year')->format('Y') - 2000 + 12;
	}
	public function _getAdYear () {
		return $this->get('exa_year')->format('Y');
	}
}
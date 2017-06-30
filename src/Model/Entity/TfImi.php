<?php
namespace App\Model\Entity;

use App\Model\Table\TfImiTable;
use Cake\ORM\Entity;

/**
 * TfImi Entity
 *
 * @property int $imicode
 * @property int $exanum
 * @property int $strategy_imisum
 * @property int $technology_imisum
 * @property int $management_imisum
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
    //合計を取得
    public function _getImiSum(){
    	return $this->strategy_imisum + $this->technology_imisum + $this->management_imisum;
    }
    public function _getAverage () {
    	return round($this->_getImiSum() / $this->imipepnum, 1);
    }
    public function _getName (TfImiTable $table) {
    	return $this->mf_exa->_getExamDetail() . $table->getImplNum($this->imicode, $this->exanum);
    }
}

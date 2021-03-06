<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TfSum Entity
 *
 * @property string $regnum
 * @property int $imicode
 * @property int $strategy_sum
 * @property int $technology_sum
 * @property int $management_sum
 *
 * @property \App\Model\Entity\TfImi $tf_imi
 * @property \App\Model\Entity\MfStu $mf_stu
 */
class TfSum extends Entity
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
        'regnum' => false,
        'imicode' => false
    ];
    public function _getStudentSum () {
    	return $this->management_sum + $this->strategy_sum + $this->technology_sum;
    }
    public function _getGenreArray() {
    	return [
    		'tech' => $this->technology_sum,
	        'man' =>  $this->management_sum,
		    'str' =>  $this->strategy_sum];
    }
}

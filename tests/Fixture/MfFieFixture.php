<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MfFieFixture
 *
 */
class MfFieFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'mf_fie';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'fienum' => ['type' => 'string', 'fixed' => true, 'length' => 1, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'fiename' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['fienum'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'fienum' => '69d5a340-16a0-4bcf-a23e-689108ba2d3c',
            'fiename' => 'Lorem ipsum dolor '
        ],
    ];
}

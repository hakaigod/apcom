<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TfSumFixture
 *
 */
class TfSumFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'tf_sum';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'regnum' => ['type' => 'string', 'fixed' => true, 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'imicode' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'strategy_sum' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'technology_sum' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'management_sum' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'imicode' => ['type' => 'index', 'columns' => ['imicode'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['regnum', 'imicode'], 'length' => []],
            'tf_sum_ibfk_1' => ['type' => 'foreign', 'columns' => ['imicode'], 'references' => ['tf_imi', 'imicode'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tf_sum_ibfk_2' => ['type' => 'foreign', 'columns' => ['regnum'], 'references' => ['mf_stu', 'regnum'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'regnum' => '7f2f9a84-8c14-4775-a31c-6685dd7caa9d',
            'imicode' => 1,
            'strategy_sum' => 1,
            'technology_sum' => 1,
            'management_sum' => 1
        ],
    ];
}

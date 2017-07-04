<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MfStuFixture
 *
 */
class MfStuFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'mf_stu';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'regnum' => ['type' => 'string', 'fixed' => true, 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'stuname' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'stuyear' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'stupass' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'depnum' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'last_update' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'graduate_flg' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted_flg' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'depnum' => ['type' => 'index', 'columns' => ['depnum'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['regnum'], 'length' => []],
            'mf_stu_ibfk_1' => ['type' => 'foreign', 'columns' => ['depnum'], 'references' => ['mf_dep', 'depnum'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'regnum' => 'ac240875-997d-4faa-b98d-32607f089779',
            'stuname' => 'Lorem ipsum dolor ',
            'stuyear' => 1,
            'stupass' => 'Lorem ipsum dolor sit amet',
            'depnum' => 1,
            'last_update' => 1499131572,
            'graduate_flg' => 1,
            'deleted_flg' => 1
        ],
    ];
}

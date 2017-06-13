<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TfAnsFixture
 *
 */
class TfAnsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'imicode' => ['type' => 'integer', 'length' => 6, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qesnum' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'regnum' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'rejoinder' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'confidence' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'qesnum' => ['type' => 'index', 'columns' => ['qesnum'], 'length' => []],
            'regnum' => ['type' => 'index', 'columns' => ['regnum'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['imicode', 'qesnum', 'regnum'], 'length' => []],
            'tf_ans_ibfk_1' => ['type' => 'foreign', 'columns' => ['imicode'], 'references' => ['tf_imi', 'imicode'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tf_ans_ibfk_2' => ['type' => 'foreign', 'columns' => ['qesnum'], 'references' => ['mf_qes', 'qesnum'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tf_ans_ibfk_3' => ['type' => 'foreign', 'columns' => ['regnum'], 'references' => ['mf_stu', 'regnum'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
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
            'imicode' => 1,
            'qesnum' => 'd1834561-7982-4e8b-b4f3-b02298bd6f89',
            'regnum' => 'ab879867-6b0d-4c22-9dd2-89de927c376a',
            'rejoinder' => 1,
            'confidence' => 1
        ],
    ];
}

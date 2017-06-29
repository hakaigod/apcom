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
        'qesnum' => ['type' => 'integer', 'length' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'regnum' => ['type' => 'string', 'fixed' => true, 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'rejoinder' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'confidence' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'correct_answer' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'qesnum' => ['type' => 'index', 'columns' => ['qesnum'], 'length' => []],
            'regnum' => ['type' => 'index', 'columns' => ['regnum'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['imicode', 'qesnum', 'regnum'], 'length' => []],
            'tf_ans_ibfk_1' => ['type' => 'foreign', 'columns' => ['imicode'], 'references' => ['tf_imi', 'imicode'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tf_ans_ibfk_2' => ['type' => 'foreign', 'columns' => ['regnum'], 'references' => ['mf_stu', 'regnum'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tf_ans_ibfk_3' => ['type' => 'foreign', 'columns' => ['qesnum'], 'references' => ['mf_qes', 'qesnum'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'imicode' => 1,
            'qesnum' => 1,
            'regnum' => 'db19cae7-93eb-43de-b531-dcbc88a30e1f',
            'rejoinder' => 1,
            'confidence' => 1,
            'correct_answer' => 1
        ],
    ];
}

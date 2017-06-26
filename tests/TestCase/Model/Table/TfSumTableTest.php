<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TfSumTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TfSumTable Test Case
 */
class TfSumTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TfSumTable
     */
    public $TfSum;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tf_sum',
        'app.mf_stu',
        'app.mf_dep'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TfSum') ? [] : ['className' => 'App\Model\Table\TfSumTable'];
        $this->TfSum = TableRegistry::get('TfSum', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TfSum);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

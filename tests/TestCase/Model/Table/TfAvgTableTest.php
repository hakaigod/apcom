<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TfAvgTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TfAvgTable Test Case
 */
class TfAvgTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TfAvgTable
     */
    public $TfAvg;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tf_avg'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TfAvg') ? [] : ['className' => 'App\Model\Table\TfAvgTable'];
        $this->TfAvg = TableRegistry::get('TfAvg', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TfAvg);

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

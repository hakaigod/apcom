<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TfAnsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TfAnsTable Test Case
 */
class TfAnsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TfAnsTable
     */
    public $TfAns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tf_ans'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TfAns') ? [] : ['className' => 'App\Model\Table\TfAnsTable'];
        $this->TfAns = TableRegistry::get('TfAns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TfAns);

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

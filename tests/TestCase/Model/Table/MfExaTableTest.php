<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MfExaTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MfExaTable Test Case
 */
class MfExaTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MfExaTable
     */
    public $MfExa;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mf_exa'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MfExa') ? [] : ['className' => 'App\Model\Table\MfExaTable'];
        $this->MfExa = TableRegistry::get('MfExa', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MfExa);

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

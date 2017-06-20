<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MfDepTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MfDepTable Test Case
 */
class MfDepTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MfDepTable
     */
    public $MfDep;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('MfDep') ? [] : ['className' => 'App\Model\Table\MfDepTable'];
        $this->MfDep = TableRegistry::get('MfDep', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MfDep);

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

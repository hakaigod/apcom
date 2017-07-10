<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TfImiTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TfImiTable Test Case
 */
class TfImiTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TfImiTable
     */
    public $TfImi;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tf_imi',
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
        $config = TableRegistry::exists('TfImi') ? [] : ['className' => 'App\Model\Table\TfImiTable'];
        $this->TfImi = TableRegistry::get('TfImi', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TfImi);

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

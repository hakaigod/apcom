<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MfQesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MfQesTable Test Case
 */
class MfQesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MfQesTable
     */
    public $MfQes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mf_qes',
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
        $config = TableRegistry::exists('MfQes') ? [] : ['className' => 'App\Model\Table\MfQesTable'];
        $this->MfQes = TableRegistry::get('MfQes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MfQes);

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

<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MfAdmTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MfAdmTable Test Case
 */
class MfAdmTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MfAdmTable
     */
    public $MfAdm;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mf_adm'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MfAdm') ? [] : ['className' => 'App\Model\Table\MfAdmTable'];
        $this->MfAdm = TableRegistry::get('MfAdm', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MfAdm);

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

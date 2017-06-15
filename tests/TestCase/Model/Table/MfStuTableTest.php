<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MfStuTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MfStuTable Test Case
 */
class MfStuTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MfStuTable
     */
    public $MfStu;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mf_stu'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MfStu') ? [] : ['className' => 'App\Model\Table\MfStuTable'];
        $this->MfStu = TableRegistry::get('MfStu', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MfStu);

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

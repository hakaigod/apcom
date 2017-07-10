<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MfFieTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MfFieTable Test Case
 */
class MfFieTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MfFieTable
     */
    public $MfFie;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mf_fie'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MfFie') ? [] : ['className' => 'App\Model\Table\MfFieTable'];
        $this->MfFie = TableRegistry::get('MfFie', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MfFie);

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

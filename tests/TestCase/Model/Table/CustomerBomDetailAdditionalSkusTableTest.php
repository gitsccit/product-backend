<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable;

/**
 * ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable Test Case
 */
class CustomerBomDetailAdditionalSkusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable
     */
    protected $CustomerBomDetailAdditionalSkus;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.ProductBackend.CustomerBomDetailAdditionalSkus',
        'plugin.ProductBackend.CustomerBomDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CustomerBomDetailAdditionalSkus') ? [] : ['className' => CustomerBomDetailAdditionalSkusTable::class];
        $this->CustomerBomDetailAdditionalSkus = $this->getTableLocator()->get('CustomerBomDetailAdditionalSkus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CustomerBomDetailAdditionalSkus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\CustomerProductsTable;

/**
 * ProductBackend\Model\Table\CustomerProductsTable Test Case
 */
class CustomerProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\CustomerProductsTable
     */
    protected $CustomerProducts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.CustomerProducts',
        'plugin.ProductBackend.Customers',
        'plugin.ProductBackend.CustomerCategories',
        'plugin.ProductBackend.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CustomerProducts') ? [] : ['className' => CustomerProductsTable::class];
        $this->CustomerProducts = $this->getTableLocator()->get('CustomerProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CustomerProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\CustomerProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\CustomerProductsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\CustomerProductsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

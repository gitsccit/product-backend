<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\ProductsTable;

/**
 * ProductBackend\Model\Table\ProductsTable Test Case
 */
class ProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\ProductsTable
     */
    protected $Products;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.ProductBackend.Products',
        'plugin.ProductBackend.ProductCategories',
        'plugin.ProductBackend.Galleries',
        'plugin.ProductBackend.Manufacturers',
        'plugin.ProductBackend.ProductStatuses',
        'plugin.ProductBackend.ShipBoxes',
        'plugin.ProductBackend.Locations',
        'plugin.ProductBackend.CustomerProducts',
        'plugin.ProductBackend.Generics',
        'plugin.ProductBackend.GroupItems',
        'plugin.ProductBackend.ProductAdditionalSkus',
        'plugin.ProductBackend.ProductPerspectives',
        'plugin.ProductBackend.ProductPriceLevels',
        'plugin.ProductBackend.ProductRules',
        'plugin.ProductBackend.ProductsRelations',
        'plugin.ProductBackend.Spares',
        'plugin.ProductBackend.Specifications',
        'plugin.ProductBackend.ViewProductBrowseImages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Products') ? [] : ['className' => ProductsTable::class];
        $this->Products = $this->getTableLocator()->get('Products', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Products);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ProductsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ProductsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

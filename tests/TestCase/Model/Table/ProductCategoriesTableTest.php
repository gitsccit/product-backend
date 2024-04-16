<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\ProductCategoriesTable;

/**
 * ProductBackend\Model\Table\ProductCategoriesTable Test Case
 */
class ProductCategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\ProductCategoriesTable
     */
    protected $ProductCategories;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.ProductCategories',
        'plugin.ProductBackend.ProductCategoryPerspectives',
        'plugin.ProductBackend.ProductCategoryRelations',
        'plugin.ProductBackend.Products',
        'plugin.ProductBackend.RaidMaps',
        'plugin.ProductBackend.SpareCategoryRelations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductCategories') ? [] : ['className' => ProductCategoriesTable::class];
        $this->ProductCategories = $this->getTableLocator()->get('ProductCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductCategories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ProductCategoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ProductCategoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ProductCategoriesTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

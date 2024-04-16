<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\SystemsTable;

/**
 * ProductBackend\Model\Table\SystemsTable Test Case
 */
class SystemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\SystemsTable
     */
    protected $Systems;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.Systems',
        'plugin.ProductBackend.Kits',
        'plugin.ProductBackend.SystemCategories',
        'plugin.ProductBackend.GroupItems',
        'plugin.ProductBackend.SystemItems',
        'plugin.ProductBackend.SystemPerspectives',
        'plugin.ProductBackend.SystemPriceLevels',
        'plugin.ProductBackend.ViewSystemBrowseImages',
        'plugin.ProductBackend.ViewSystemSystemImages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Systems') ? [] : ['className' => SystemsTable::class];
        $this->Systems = $this->getTableLocator()->get('Systems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Systems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SystemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SystemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SystemsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\TabsTable;

/**
 * ProductBackend\Model\Table\TabsTable Test Case
 */
class TabsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\TabsTable
     */
    protected $Tabs;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.Tabs',
        'plugin.ProductBackend.Files',
        'plugin.ProductBackend.Plugins',
        'plugin.ProductBackend.BucketCategories',
        'plugin.ProductBackend.Buckets',
        'plugin.ProductBackend.TabPerspectives',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Tabs') ? [] : ['className' => TabsTable::class];
        $this->Tabs = $this->getTableLocator()->get('Tabs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Tabs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\TabsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\TabsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\TabsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

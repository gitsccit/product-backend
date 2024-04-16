<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\PluginsTable;

/**
 * ProductBackend\Model\Table\PluginsTable Test Case
 */
class PluginsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\PluginsTable
     */
    protected $Plugins;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.Plugins',
        'plugin.ProductBackend.Buckets',
        'plugin.ProductBackend.PluginPerspectives',
        'plugin.ProductBackend.Tabs',
        'plugin.ProductBackend.Kits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Plugins') ? [] : ['className' => PluginsTable::class];
        $this->Plugins = $this->getTableLocator()->get('Plugins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Plugins);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\PluginsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\PluginsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\PerspectivesTable;

/**
 * ProductBackend\Model\Table\PerspectivesTable Test Case
 */
class PerspectivesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\PerspectivesTable
     */
    protected $Perspectives;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.Perspectives',
        'plugin.ProductBackend.Customers',
        'plugin.ProductBackend.PluginPerspectives',
        'plugin.ProductBackend.PriceLevelPerspectives',
        'plugin.ProductBackend.ProductCategoryPerspectives',
        'plugin.ProductBackend.ProductPerspectives',
        'plugin.ProductBackend.SystemCategoryPerspectives',
        'plugin.ProductBackend.SystemPerspectives',
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
        $config = $this->getTableLocator()->exists('Perspectives') ? [] : ['className' => PerspectivesTable::class];
        $this->Perspectives = $this->getTableLocator()->get('Perspectives', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Perspectives);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\PerspectivesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\PerspectivesTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\SystemPriceLevelsTable;

/**
 * ProductBackend\Model\Table\SystemPriceLevelsTable Test Case
 */
class SystemPriceLevelsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\SystemPriceLevelsTable
     */
    protected $SystemPriceLevels;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.SystemPriceLevels',
        'plugin.ProductBackend.PriceLevels',
        'plugin.ProductBackend.Systems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SystemPriceLevels') ? [] : ['className' => SystemPriceLevelsTable::class];
        $this->SystemPriceLevels = $this->getTableLocator()->get('SystemPriceLevels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SystemPriceLevels);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SystemPriceLevelsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SystemPriceLevelsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SystemPriceLevelsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

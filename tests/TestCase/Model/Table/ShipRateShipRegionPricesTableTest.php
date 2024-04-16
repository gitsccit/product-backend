<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\ShipRateShipRegionPricesTable;

/**
 * ProductBackend\Model\Table\ShipRateShipRegionPricesTable Test Case
 */
class ShipRateShipRegionPricesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\ShipRateShipRegionPricesTable
     */
    protected $ShipRateShipRegionPrices;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.ProductBackend.ShipRateShipRegionPrices',
        'plugin.ProductBackend.ShipRates',
        'plugin.ProductBackend.ShipRegions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ShipRateShipRegionPrices') ? [] : ['className' => ShipRateShipRegionPricesTable::class];
        $this->ShipRateShipRegionPrices = $this->getTableLocator()->get('ShipRateShipRegionPrices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ShipRateShipRegionPrices);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ShipRateShipRegionPricesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ShipRateShipRegionPricesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\ShipRateShipRegionPricesTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

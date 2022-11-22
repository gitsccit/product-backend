<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\KitsTable;

/**
 * ProductBackend\Model\Table\KitsTable Test Case
 */
class KitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\KitsTable
     */
    protected $Kits;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.ProductBackend.Kits',
        'plugin.ProductBackend.Locations',
        'plugin.ProductBackend.ShipBoxes',
        'plugin.ProductBackend.KitBuckets',
        'plugin.ProductBackend.KitItems',
        'plugin.ProductBackend.KitOptionCodes',
        'plugin.ProductBackend.KitRules',
        'plugin.ProductBackend.Systems',
        'plugin.ProductBackend.ViewKitBrowseTags',
        'plugin.ProductBackend.ViewKitCardTags',
        'plugin.ProductBackend.ViewKitTags',
        'plugin.ProductBackend.Icons',
        'plugin.ProductBackend.Plugins',
        'plugin.ProductBackend.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Kits') ? [] : ['className' => KitsTable::class];
        $this->Kits = $this->getTableLocator()->get('Kits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Kits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\KitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\KitsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\KitsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

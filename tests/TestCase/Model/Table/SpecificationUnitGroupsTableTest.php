<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\SpecificationUnitGroupsTable;

/**
 * ProductBackend\Model\Table\SpecificationUnitGroupsTable Test Case
 */
class SpecificationUnitGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\SpecificationUnitGroupsTable
     */
    protected $SpecificationUnitGroups;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.ProductBackend.SpecificationUnitGroups',
        'plugin.ProductBackend.SpecificationFields',
        'plugin.ProductBackend.SpecificationUnits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SpecificationUnitGroups') ? [] : ['className' => SpecificationUnitGroupsTable::class];
        $this->SpecificationUnitGroups = $this->getTableLocator()->get('SpecificationUnitGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SpecificationUnitGroups);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SpecificationUnitGroupsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SpecificationUnitGroupsTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

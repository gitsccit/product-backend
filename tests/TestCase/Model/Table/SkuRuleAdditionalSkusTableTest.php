<?php
declare(strict_types=1);

namespace ProductBackend\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ProductBackend\Model\Table\SkuRuleAdditionalSkusTable;

/**
 * ProductBackend\Model\Table\SkuRuleAdditionalSkusTable Test Case
 */
class SkuRuleAdditionalSkusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ProductBackend\Model\Table\SkuRuleAdditionalSkusTable
     */
    protected $SkuRuleAdditionalSkus;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.ProductBackend.SkuRuleAdditionalSkus',
        'plugin.ProductBackend.SkuRules',
        'plugin.ProductBackend.SkuRuleGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SkuRuleAdditionalSkus') ? [] : ['className' => SkuRuleAdditionalSkusTable::class];
        $this->SkuRuleAdditionalSkus = $this->getTableLocator()->get('SkuRuleAdditionalSkus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SkuRuleAdditionalSkus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SkuRuleAdditionalSkusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SkuRuleAdditionalSkusTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     * @uses \ProductBackend\Model\Table\SkuRuleAdditionalSkusTable::defaultConnectionName()
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

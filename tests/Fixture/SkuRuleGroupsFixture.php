<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SkuRuleGroupsFixture
 */
class SkuRuleGroupsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'sku_rule_id' => 1,
                'method' => 'Lorem ipsum dolor sit amet',
                'spec_id' => 1,
                'value' => 'Lorem ipsum dolor ',
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}

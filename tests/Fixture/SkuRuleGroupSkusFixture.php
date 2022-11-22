<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SkuRuleGroupSkusFixture
 */
class SkuRuleGroupSkusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'sku_rule_group_skus';
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
                'sku_rule_group_id' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

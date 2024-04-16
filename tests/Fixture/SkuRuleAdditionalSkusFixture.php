<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SkuRuleAdditionalSkusFixture
 */
class SkuRuleAdditionalSkusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'sku_rule_additional_skus';
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
                'quantity' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'sku_rule_group_id' => 1,
                'quantity_modifier' => 1,
                'sell_price' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

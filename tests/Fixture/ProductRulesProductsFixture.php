<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductRulesProductsFixture
 */
class ProductRulesProductsFixture extends TestFixture
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
                'product_rule_id' => 1,
                'product_id' => 1,
            ],
        ];
        parent::init();
    }
}

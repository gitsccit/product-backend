<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductPriceLevelsFixture
 */
class ProductPriceLevelsFixture extends TestFixture
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
                'price_level_id' => 1,
                'product_id' => 1,
                'logic' => 'Lorem ipsum dolor sit amet',
                'value' => 1,
                'price' => 1,
                'timestamp' => 1669071863,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShipRateShipRegionPricesFixture
 */
class ShipRateShipRegionPricesFixture extends TestFixture
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
                'ship_rate_id' => 1,
                'ship_region_id' => 1,
                'price' => 1.5,
            ],
        ];
        parent::init();
    }
}

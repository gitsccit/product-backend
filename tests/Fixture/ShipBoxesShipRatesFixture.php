<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShipBoxesShipRatesFixture
 */
class ShipBoxesShipRatesFixture extends TestFixture
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
                'ship_box_id' => 1,
                'ship_rate_id' => 1,
            ],
        ];
        parent::init();
    }
}

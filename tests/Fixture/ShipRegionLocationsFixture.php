<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShipRegionLocationsFixture
 */
class ShipRegionLocationsFixture extends TestFixture
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
                'ship_region_id' => 1,
                'country' => 'L',
                'state' => 'Lo',
            ],
        ];
        parent::init();
    }
}

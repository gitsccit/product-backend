<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitsFixture
 */
class KitsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'build_time' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'product_rules' => 'Lorem ipsum dolor sit amet',
                'sku_rules' => 'Lorem ipsum dolor sit amet',
                'noise_level' => 'Lorem ipsum dolor sit amet',
                'power_estimate' => 'Lorem ipsum dolor sit amet',
                'pallet_ship' => 'Lorem ipsum dolor sit amet',
                'spares_kit' => 'Lorem ipsum dolor sit amet',
                'ship_from_id' => 1,
                'ship_box_id' => 1,
                'length' => 1,
                'width' => 1,
                'height' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'date_added' => 1669071819,
                'timestamp' => 1669071819,
            ],
        ];
        parent::init();
    }
}

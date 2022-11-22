<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
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
                'url' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'product_category_id' => 1,
                'gallery_id' => 1,
                'manufacturer_id' => 1,
                'part_number' => 'Lorem ipsum dolor sit amet',
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'upc' => 'Lorem ipsum ',
                'status_id' => 1,
                'status_text' => 'Lorem ipsum dolor sit amet',
                'tax' => 'Lorem ipsum dolor sit amet',
                'cost' => 1,
                'cost_maintenance' => 'Lorem ipsum dolor sit amet',
                'generic' => 'Lorem ipsum dolor sit amet',
                'noise_level' => 1,
                'generic_relations' => 'Lorem ipsum dolor sit amet',
                'kit_price_percent' => 1,
                'show_related_systems' => 'Lorem ipsum dolor sit amet',
                'ship_box_id' => 1,
                'ship_type' => 'Lorem ipsum dolor sit amet',
                'weight' => 1,
                'length' => 1,
                'width' => 1,
                'height' => 1,
                'country_of_origin_id' => 1,
                'ship_from_id' => 1,
                'lithium_battery' => 'Lorem ipsum dolor sit amet',
                'watts' => 1,
                'system_use' => 1,
                'system_start' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'date_eol' => '2022-11-21',
                'date_added' => 1669071878,
                'timestamp' => 1669071878,
            ],
        ];
        parent::init();
    }
}

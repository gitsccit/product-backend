<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomerBomsFixture
 */
class CustomerBomsFixture extends TestFixture
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
                'customer_id' => 1,
                'customer_category_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'location_id' => 1,
                'image_id' => 1,
                'bstock' => 'Lorem ipsum dolor sit amet',
                'price' => 1,
                'palletship' => 'Lorem ipsum dolor sit amet',
                'weight' => 1,
                'length' => 1,
                'width' => 1,
                'height' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'date_added' => 1669071764,
                'timestamp' => 1669071764,
            ],
        ];
        parent::init();
    }
}

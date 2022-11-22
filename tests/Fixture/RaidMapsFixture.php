<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RaidMapsFixture
 */
class RaidMapsFixture extends TestFixture
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
                'product_category_id' => 1,
                'device' => 'Lorem ipsum dolor sit amet',
                'interface' => 'Lorem ipsum dolor sit amet',
                'interface_spec_id' => 1,
                'interface2_spec_id' => 1,
                'name_spec_id' => 1,
                'raid_spec_id' => 1,
                'ports_spec_id' => 1,
                'devices_spec_id' => 1,
                'pergroup_spec_id' => 1,
                'capacity_spec_id' => 1,
                'backplane_spec_id' => 1,
            ],
        ];
        parent::init();
    }
}

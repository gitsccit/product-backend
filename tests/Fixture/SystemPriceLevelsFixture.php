<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemPriceLevelsFixture
 */
class SystemPriceLevelsFixture extends TestFixture
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
                'system_id' => 1,
                'logic' => 'Lorem ipsum dolor sit amet',
                'value' => 1,
                'fpa' => 1,
                'price' => 1,
                'timestamp' => 1669071968,
            ],
        ];
        parent::init();
    }
}

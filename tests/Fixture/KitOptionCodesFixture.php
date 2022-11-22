<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitOptionCodesFixture
 */
class KitOptionCodesFixture extends TestFixture
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
                'kit_id' => 1,
                'part_number' => 'Lorem ipsum dolor sit amet',
                'positions' => 1,
            ],
        ];
        parent::init();
    }
}

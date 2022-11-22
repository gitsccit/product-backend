<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitOptionCodeItemsFixture
 */
class KitOptionCodeItemsFixture extends TestFixture
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
                'kit_option_code_id' => 1,
                'kit_item_id' => 1,
                'position' => 1,
                'part_number' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}

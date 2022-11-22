<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemItemsFixture
 */
class SystemItemsFixture extends TestFixture
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
                'system_id' => 1,
                'item_id' => 1,
                'quantity' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemReplacementsFixture
 */
class SystemReplacementsFixture extends TestFixture
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
                'system_category_path' => 'Lorem ipsum dolor sit amet',
                'replacement_system_id' => 1,
            ],
        ];
        parent::init();
    }
}

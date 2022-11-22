<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpecificationsFixture
 */
class SpecificationsFixture extends TestFixture
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
                'product_id' => 1,
                'specification_field_id' => 1,
                'sequence' => 1,
                'specification_unit_id' => 1,
                'text_value' => 'Lorem ipsum dolor sit amet',
                'unit_value' => 1,
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpareCategoryRelationsFixture
 */
class SpareCategoryRelationsFixture extends TestFixture
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
                'spare_category_id' => 1,
                'product_category_id' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductCategoryRelationsFixture
 */
class ProductCategoryRelationsFixture extends TestFixture
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
                'product_category_id' => 1,
                'related_product_category_id' => 1,
            ],
        ];
        parent::init();
    }
}

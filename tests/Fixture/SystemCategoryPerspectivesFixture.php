<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemCategoryPerspectivesFixture
 */
class SystemCategoryPerspectivesFixture extends TestFixture
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
                'perspective_id' => 1,
                'system_category_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'banner_id' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'children' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagCategoriesTagGroupsFixture
 */
class TagCategoriesTagGroupsFixture extends TestFixture
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
                'tag_category_id' => 1,
                'tag_group_id' => 1,
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}

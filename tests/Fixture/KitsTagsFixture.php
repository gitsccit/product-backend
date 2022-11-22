<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitsTagsFixture
 */
class KitsTagsFixture extends TestFixture
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
                'tag_id' => 1,
                'value' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}

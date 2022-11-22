<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BucketsGroupsFixture
 */
class BucketsGroupsFixture extends TestFixture
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
                'bucket_id' => 1,
                'group_id' => 1,
            ],
        ];
        parent::init();
    }
}

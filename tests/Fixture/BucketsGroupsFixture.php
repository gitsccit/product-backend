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
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'bucket_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'group_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_buckets_bucket_groups_bucket_groups' => ['type' => 'index', 'columns' => ['group_id'], 'length' => []],
            'FK_buckets_bucket_groups_buckets' => ['type' => 'index', 'columns' => ['bucket_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_buckets_bucket_groups_buckets' => ['type' => 'foreign', 'columns' => ['bucket_id'], 'references' => ['buckets', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_buckets_bucket_groups_bucket_groups' => ['type' => 'foreign', 'columns' => ['group_id'], 'references' => ['groups', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // phpcs:enable
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

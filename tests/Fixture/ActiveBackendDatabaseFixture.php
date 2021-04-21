<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActiveBackendDatabaseFixture
 */
class ActiveBackendDatabaseFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'active_backend_database';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'timestamp' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
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
                'name' => 'Lorem ipsum dolor sit amet',
                'timestamp' => 1618931059,
            ],
        ];
        parent::init();
    }
}

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
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'timestamp' => 1669071733,
            ],
        ];
        parent::init();
    }
}

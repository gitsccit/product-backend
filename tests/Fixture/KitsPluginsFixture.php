<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitsPluginsFixture
 */
class KitsPluginsFixture extends TestFixture
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
                'kit_id' => 1,
                'plugin_id' => 1,
            ],
        ];
        parent::init();
    }
}

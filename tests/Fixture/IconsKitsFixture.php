<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IconsKitsFixture
 */
class IconsKitsFixture extends TestFixture
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
                'icon_id' => 1,
                'kit_id' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IconsFixture
 */
class IconsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'image_id' => 1,
                'style' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'timestamp' => 1669071794,
            ],
        ];
        parent::init();
    }
}

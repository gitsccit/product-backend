<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BannersFixture
 */
class BannersFixture extends TestFixture
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
                'image_id' => 1,
                'tile_id' => 1,
                'horizontal' => 'Lorem ipsum dolor sit amet',
                'vertical' => 'Lorem ipsum dolor sit amet',
                'style' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'timestamp' => 1669071746,
            ],
        ];
        parent::init();
    }
}

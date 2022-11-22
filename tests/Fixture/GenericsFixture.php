<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GenericsFixture
 */
class GenericsFixture extends TestFixture
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
                'product_id' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'cost' => 1,
                'cost_maintenance' => 'Lorem ipsum dolor sit amet',
                'prioritize' => 'Lorem ipsum dolor sit amet',
                'date_added' => 1669071782,
                'timestamp' => 1669071782,
            ],
        ];
        parent::init();
    }
}

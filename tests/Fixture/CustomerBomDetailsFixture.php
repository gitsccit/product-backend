<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomerBomDetailsFixture
 */
class CustomerBomDetailsFixture extends TestFixture
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
                'customer_bom_id' => 1,
                'sequence' => 1,
                'option' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1,
                'comment' => 'Lorem ipsum dolor sit amet',
                'price' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomersFixture
 */
class CustomersFixture extends TestFixture
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
                'perspective_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'crm_account' => 1,
                'sage_customer' => 'Lorem ipsum dolor sit',
            ],
        ];
        parent::init();
    }
}

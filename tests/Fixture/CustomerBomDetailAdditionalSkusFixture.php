<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomerBomDetailAdditionalSkusFixture
 */
class CustomerBomDetailAdditionalSkusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'customer_bom_detail_additional_skus';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'customer_bom_detail_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sage_itemcode' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'quantity' => ['type' => 'smallinteger', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'string', 'length' => 2048, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'sort' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_customer_bom_detail_additional_skus_customer_bom_details' => ['type' => 'index', 'columns' => ['customer_bom_detail_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_customer_bom_detail_additional_skus_customer_bom_details' => ['type' => 'foreign', 'columns' => ['customer_bom_detail_id'], 'references' => ['customer_bom_details', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'id' => 1,
                'customer_bom_detail_id' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1,
                'comment' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}

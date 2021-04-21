<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomerBomsFixture
 */
class CustomerBomsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'customer_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'customer_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'location_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'image_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bstock' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'price' => ['type' => 'float', 'length' => 8, 'precision' => 2, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        'palletship' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'weight' => ['type' => 'float', 'length' => 7, 'precision' => 2, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        'length' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'width' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'height' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'active' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'date_added' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'timestamp' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'FK_customer_boms_customer_categories' => ['type' => 'index', 'columns' => ['customer_category_id'], 'length' => []],
            'FK_customer_boms_customers' => ['type' => 'index', 'columns' => ['customer_id'], 'length' => []],
            'FK_customer_boms_locations' => ['type' => 'index', 'columns' => ['location_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_customer_boms_locations' => ['type' => 'foreign', 'columns' => ['location_id'], 'references' => ['locations', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_customer_boms_customers' => ['type' => 'foreign', 'columns' => ['customer_id'], 'references' => ['customers', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_customer_boms_customer_categories' => ['type' => 'foreign', 'columns' => ['customer_category_id'], 'references' => ['customer_categories', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
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
                'customer_id' => 1,
                'customer_category_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'location_id' => 1,
                'image_id' => 1,
                'bstock' => 'Lorem ipsum dolor sit amet',
                'price' => 1,
                'palletship' => 'Lorem ipsum dolor sit amet',
                'weight' => 1,
                'length' => 1,
                'width' => 1,
                'height' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'date_added' => 1618931074,
                'timestamp' => 1618931074,
            ],
        ];
        parent::init();
    }
}

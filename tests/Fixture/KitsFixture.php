<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitsFixture
 */
class KitsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'build_time' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '3', 'comment' => '', 'precision' => null],
        'sage_itemcode' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => 'KTBASIC', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'product_rules' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'yes', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'sku_rules' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'yes', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'noise_level' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'power_estimate' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'pallet_ship' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'spares_kit' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'ship_from_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ship_box_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'length' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'width' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'height' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'active' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'date_added' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'timestamp' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'FK_kits_locations' => ['type' => 'index', 'columns' => ['ship_from_id'], 'length' => []],
            'FK_kits_ship_boxes' => ['type' => 'index', 'columns' => ['ship_box_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_kits_ship_boxes' => ['type' => 'foreign', 'columns' => ['ship_box_id'], 'references' => ['ship_boxes', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_kits_locations' => ['type' => 'foreign', 'columns' => ['ship_from_id'], 'references' => ['locations', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
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
                'name' => 'Lorem ipsum dolor sit amet',
                'build_time' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'product_rules' => 'Lorem ipsum dolor sit amet',
                'sku_rules' => 'Lorem ipsum dolor sit amet',
                'noise_level' => 'Lorem ipsum dolor sit amet',
                'power_estimate' => 'Lorem ipsum dolor sit amet',
                'pallet_ship' => 'Lorem ipsum dolor sit amet',
                'spares_kit' => 'Lorem ipsum dolor sit amet',
                'ship_from_id' => 1,
                'ship_box_id' => 1,
                'length' => 1,
                'width' => 1,
                'height' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'date_added' => 1618931109,
                'timestamp' => 1618931109,
            ],
        ];
        parent::init();
    }
}

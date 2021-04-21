<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'url' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => 'New Product', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'product_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'gallery_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'manufacturer_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'part_number' => ['type' => 'string', 'length' => 40, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'sage_itemcode' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'upc' => ['type' => 'string', 'length' => 14, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'status_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'status_text' => ['type' => 'string', 'length' => 130, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'tax' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'standard', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'cost' => ['type' => 'float', 'length' => 8, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '0.00', 'comment' => ''],
        'cost_maintenance' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'manual', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'generic' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'noise_level' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'generic_relations' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'require', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'kit_price_percent' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'show_related_systems' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'ship_box_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ship_type' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'standard', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'weight' => ['type' => 'float', 'length' => 7, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => '1.00', 'comment' => ''],
        'length' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'width' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'height' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'country_of_origin_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ship_from_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'lithium_battery' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'watts' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => ''],
        'system_use' => ['type' => 'smallinteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'system_start' => ['type' => 'smallinteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'sort' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date_eol' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'date_added' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'timestamp' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'FK_products_locations' => ['type' => 'index', 'columns' => ['country_of_origin_id'], 'length' => []],
            'FK_products_locations_2' => ['type' => 'index', 'columns' => ['ship_from_id'], 'length' => []],
            'FK_products_product_categories' => ['type' => 'index', 'columns' => ['product_category_id'], 'length' => []],
            'FK_products_manufacturers' => ['type' => 'index', 'columns' => ['manufacturer_id'], 'length' => []],
            'FK_products_statuses' => ['type' => 'index', 'columns' => ['status_id'], 'length' => []],
            'FK_products_ship_boxes' => ['type' => 'index', 'columns' => ['ship_box_id'], 'length' => []],
            'url' => ['type' => 'index', 'columns' => ['url'], 'length' => []],
            'FK_products_galleries' => ['type' => 'index', 'columns' => ['gallery_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_products_locations_2' => ['type' => 'foreign', 'columns' => ['ship_from_id'], 'references' => ['locations', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_products_locations' => ['type' => 'foreign', 'columns' => ['country_of_origin_id'], 'references' => ['locations', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_products_galleries' => ['type' => 'foreign', 'columns' => ['gallery_id'], 'references' => ['galleries', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_products_statuses' => ['type' => 'foreign', 'columns' => ['status_id'], 'references' => ['product_statuses', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_products_ship_boxes' => ['type' => 'foreign', 'columns' => ['ship_box_id'], 'references' => ['ship_boxes', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_products_product_categories' => ['type' => 'foreign', 'columns' => ['product_category_id'], 'references' => ['product_categories', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_products_manufacturers' => ['type' => 'foreign', 'columns' => ['manufacturer_id'], 'references' => ['manufacturers', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
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
                'url' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'product_category_id' => 1,
                'gallery_id' => 1,
                'manufacturer_id' => 1,
                'part_number' => 'Lorem ipsum dolor sit amet',
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'upc' => 'Lorem ipsum ',
                'status_id' => 1,
                'status_text' => 'Lorem ipsum dolor sit amet',
                'tax' => 'Lorem ipsum dolor sit amet',
                'cost' => 1,
                'cost_maintenance' => 'Lorem ipsum dolor sit amet',
                'generic' => 'Lorem ipsum dolor sit amet',
                'noise_level' => 1,
                'generic_relations' => 'Lorem ipsum dolor sit amet',
                'kit_price_percent' => 1,
                'show_related_systems' => 'Lorem ipsum dolor sit amet',
                'ship_box_id' => 1,
                'ship_type' => 'Lorem ipsum dolor sit amet',
                'weight' => 1,
                'length' => 1,
                'width' => 1,
                'height' => 1,
                'country_of_origin_id' => 1,
                'ship_from_id' => 1,
                'lithium_battery' => 'Lorem ipsum dolor sit amet',
                'watts' => 1,
                'system_use' => 1,
                'system_start' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'date_eol' => '2021-04-20',
                'date_added' => 1618931147,
                'timestamp' => 1618931147,
            ],
        ];
        parent::init();
    }
}

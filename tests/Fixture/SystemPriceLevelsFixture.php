<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemPriceLevelsFixture
 */
class SystemPriceLevelsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'price_level_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'system_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'logic' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'default', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'value' => ['type' => 'float', 'length' => 11, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'fpa' => ['type' => 'float', 'length' => 11, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'fixed price adjustment'],
        'price' => ['type' => 'float', 'length' => 11, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'this field is derived from fixedprice, or cost * markup'],
        'timestamp' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'FK_system_price_levels_price_levels' => ['type' => 'index', 'columns' => ['price_level_id'], 'length' => []],
            'FK_system_price_levels_products' => ['type' => 'index', 'columns' => ['system_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_system_price_levels_products' => ['type' => 'foreign', 'columns' => ['system_id'], 'references' => ['systems', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_system_price_levels_price_levels' => ['type' => 'foreign', 'columns' => ['price_level_id'], 'references' => ['price_levels', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'price_level_id' => 1,
                'system_id' => 1,
                'logic' => 'Lorem ipsum dolor sit amet',
                'value' => 1,
                'fpa' => 1,
                'price' => 1,
                'timestamp' => 1618931200,
            ],
        ];
        parent::init();
    }
}

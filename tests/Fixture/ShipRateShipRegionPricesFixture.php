<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShipRateShipRegionPricesFixture
 */
class ShipRateShipRegionPricesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'ship_rate_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ship_region_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'price' => ['type' => 'decimal', 'length' => 7, 'precision' => 2, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'FK_ship_rate_ship_region_prices_ship_rates' => ['type' => 'index', 'columns' => ['ship_rate_id'], 'length' => []],
            'FK_ship_rate_ship_region_prices_ship_regions' => ['type' => 'index', 'columns' => ['ship_region_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_ship_rate_ship_region_prices_ship_regions' => ['type' => 'foreign', 'columns' => ['ship_region_id'], 'references' => ['ship_regions', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_ship_rate_ship_region_prices_ship_rates' => ['type' => 'foreign', 'columns' => ['ship_rate_id'], 'references' => ['ship_rates', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'ship_rate_id' => 1,
                'ship_region_id' => 1,
                'price' => 1.5,
            ],
        ];
        parent::init();
    }
}

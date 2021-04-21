<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShipBoxesShipRatesFixture
 */
class ShipBoxesShipRatesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'ship_box_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ship_rate_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_ship_boxes_ship_rates_ship_boxes' => ['type' => 'index', 'columns' => ['ship_box_id'], 'length' => []],
            'FK_ship_boxes_ship_rates_ship_rates' => ['type' => 'index', 'columns' => ['ship_rate_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_ship_boxes_ship_rates_ship_rates' => ['type' => 'foreign', 'columns' => ['ship_rate_id'], 'references' => ['ship_rates', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_ship_boxes_ship_rates_ship_boxes' => ['type' => 'foreign', 'columns' => ['ship_box_id'], 'references' => ['ship_boxes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'ship_box_id' => 1,
                'ship_rate_id' => 1,
            ],
        ];
        parent::init();
    }
}

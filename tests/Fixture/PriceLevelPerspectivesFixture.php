<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PriceLevelPerspectivesFixture
 */
class PriceLevelPerspectivesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'perspective_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'price_level_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'active' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_price_level_perspectives_perspectives' => ['type' => 'index', 'columns' => ['perspective_id'], 'length' => []],
            'FK_price_level_perspectives_price_levels' => ['type' => 'index', 'columns' => ['price_level_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_price_level_perspectives_price_levels' => ['type' => 'foreign', 'columns' => ['price_level_id'], 'references' => ['price_levels', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_price_level_perspectives_perspectives' => ['type' => 'foreign', 'columns' => ['perspective_id'], 'references' => ['perspectives', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'perspective_id' => 1,
                'price_level_id' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

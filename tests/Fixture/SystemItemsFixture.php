<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemItemsFixture
 */
class SystemItemsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'system_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'item_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_system_items_systems' => ['type' => 'index', 'columns' => ['system_id'], 'length' => []],
            'FK_system_items_bucket_items' => ['type' => 'index', 'columns' => ['item_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_system_items_systems' => ['type' => 'foreign', 'columns' => ['system_id'], 'references' => ['systems', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_system_items_bucket_items' => ['type' => 'foreign', 'columns' => ['item_id'], 'references' => ['group_items', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'system_id' => 1,
                'item_id' => 1,
                'quantity' => 1,
            ],
        ];
        parent::init();
    }
}

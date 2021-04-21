<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitsPluginsFixture
 */
class KitsPluginsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'kit_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'plugin_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_kits_plugins_kits' => ['type' => 'index', 'columns' => ['kit_id'], 'length' => []],
            'FK_kits_plugins_plugins' => ['type' => 'index', 'columns' => ['plugin_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_kits_plugins_plugins' => ['type' => 'foreign', 'columns' => ['plugin_id'], 'references' => ['plugins', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_kits_plugins_kits' => ['type' => 'foreign', 'columns' => ['kit_id'], 'references' => ['kits', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'kit_id' => 1,
                'plugin_id' => 1,
            ],
        ];
        parent::init();
    }
}

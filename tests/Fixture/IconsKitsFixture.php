<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IconsKitsFixture
 */
class IconsKitsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'icon_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'kit_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_icons_kits_icons' => ['type' => 'index', 'columns' => ['icon_id'], 'length' => []],
            'FK_icons_kits_kits' => ['type' => 'index', 'columns' => ['kit_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_icons_kits_kits' => ['type' => 'foreign', 'columns' => ['kit_id'], 'references' => ['kits', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_icons_kits_icons' => ['type' => 'foreign', 'columns' => ['icon_id'], 'references' => ['icons', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'icon_id' => 1,
                'kit_id' => 1,
            ],
        ];
        parent::init();
    }
}

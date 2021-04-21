<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemCategoriesFixture
 */
class SystemCategoriesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'url' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 80, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 250, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'force_perspective' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'banner_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'spares_kits' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'children' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sort' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_system_categories_banners' => ['type' => 'index', 'columns' => ['banner_id'], 'length' => []],
            'FK_system_categories_perspectives' => ['type' => 'index', 'columns' => ['force_perspective'], 'length' => []],
            'FK_system_categories_system_categories' => ['type' => 'index', 'columns' => ['parent_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_system_categories_system_categories' => ['type' => 'foreign', 'columns' => ['parent_id'], 'references' => ['system_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_system_categories_perspectives' => ['type' => 'foreign', 'columns' => ['force_perspective'], 'references' => ['perspectives', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_system_categories_banners' => ['type' => 'foreign', 'columns' => ['banner_id'], 'references' => ['banners', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'parent_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'force_perspective' => 1,
                'banner_id' => 1,
                'spares_kits' => 'Lorem ipsum dolor sit amet',
                'active' => 'Lorem ipsum dolor sit amet',
                'children' => 1,
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}

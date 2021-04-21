<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SystemCategoryPerspectivesFixture
 */
class SystemCategoryPerspectivesFixture extends TestFixture
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
        'system_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'url' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 80, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'banner_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'active' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'children' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_system_category_perspectives_banners' => ['type' => 'index', 'columns' => ['banner_id'], 'length' => []],
            'FK_system_category_perspectives_perspectives' => ['type' => 'index', 'columns' => ['perspective_id'], 'length' => []],
            'FK_system_category_perspectives_system_categories' => ['type' => 'index', 'columns' => ['system_category_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_system_category_perspectives_system_categories' => ['type' => 'foreign', 'columns' => ['system_category_id'], 'references' => ['system_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_system_category_perspectives_perspectives' => ['type' => 'foreign', 'columns' => ['perspective_id'], 'references' => ['perspectives', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_system_category_perspectives_banners' => ['type' => 'foreign', 'columns' => ['banner_id'], 'references' => ['banners', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
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
                'system_category_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'banner_id' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
                'children' => 1,
            ],
        ];
        parent::init();
    }
}

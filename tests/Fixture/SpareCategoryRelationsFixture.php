<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpareCategoryRelationsFixture
 */
class SpareCategoryRelationsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'spare_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_spare_category_relations_spare_categories' => ['type' => 'index', 'columns' => ['spare_category_id'], 'length' => []],
            'FK_spare_category_relations_product_categories' => ['type' => 'index', 'columns' => ['product_category_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_spare_category_relations_spare_categories' => ['type' => 'foreign', 'columns' => ['spare_category_id'], 'references' => ['spare_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_spare_category_relations_product_categories' => ['type' => 'foreign', 'columns' => ['product_category_id'], 'references' => ['product_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'spare_category_id' => 1,
                'product_category_id' => 1,
            ],
        ];
        parent::init();
    }
}

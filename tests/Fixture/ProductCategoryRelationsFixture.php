<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductCategoryRelationsFixture
 */
class ProductCategoryRelationsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'product_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'related_product_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_product_category_relations_product_categories' => ['type' => 'index', 'columns' => ['product_category_id'], 'length' => []],
            'FK_product_category_relations_product_categories_2' => ['type' => 'index', 'columns' => ['related_product_category_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_product_category_relations_product_categories_2' => ['type' => 'foreign', 'columns' => ['related_product_category_id'], 'references' => ['product_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_product_category_relations_product_categories' => ['type' => 'foreign', 'columns' => ['product_category_id'], 'references' => ['product_categories', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'product_category_id' => 1,
                'related_product_category_id' => 1,
            ],
        ];
        parent::init();
    }
}

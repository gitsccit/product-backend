<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SparesFixture
 */
class SparesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'product_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'spare_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'related_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'active' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_spares_products' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
            'FK_spares_spare_categories' => ['type' => 'index', 'columns' => ['spare_category_id'], 'length' => []],
            'FK_spares_products_2' => ['type' => 'index', 'columns' => ['related_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_spares_spare_categories' => ['type' => 'foreign', 'columns' => ['spare_category_id'], 'references' => ['spare_categories', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'FK_spares_products_2' => ['type' => 'foreign', 'columns' => ['related_id'], 'references' => ['products', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'FK_spares_products' => ['type' => 'foreign', 'columns' => ['product_id'], 'references' => ['products', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
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
                'product_id' => 1,
                'spare_category_id' => 1,
                'related_id' => 1,
                'active' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

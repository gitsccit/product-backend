<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductRulesProductsFixture
 */
class ProductRulesProductsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'product_rule_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_product_rules_products_product_rules' => ['type' => 'index', 'columns' => ['product_rule_id'], 'length' => []],
            'FK_product_rules_products_products' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_product_rules_products_products' => ['type' => 'foreign', 'columns' => ['product_id'], 'references' => ['products', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_product_rules_products_product_rules' => ['type' => 'foreign', 'columns' => ['product_rule_id'], 'references' => ['product_rules', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'product_rule_id' => 1,
                'product_id' => 1,
            ],
        ];
        parent::init();
    }
}

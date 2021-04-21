<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SkuRuleAdditionalSkusFixture
 */
class SkuRuleAdditionalSkusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'sku_rule_additional_skus';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'sku_rule_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'sage_itemcode' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'sku_rule_group_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity_modifier' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'sell_price' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_sku_rule_additional_skus_sku_rule_groups' => ['type' => 'index', 'columns' => ['sku_rule_group_id'], 'length' => []],
            'FK_sku_rule_additional_skus_sku_rules' => ['type' => 'index', 'columns' => ['sku_rule_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_sku_rule_additional_skus_sku_rules' => ['type' => 'foreign', 'columns' => ['sku_rule_id'], 'references' => ['sku_rules', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_sku_rule_additional_skus_sku_rule_groups' => ['type' => 'foreign', 'columns' => ['sku_rule_group_id'], 'references' => ['sku_rule_groups', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
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
                'sku_rule_id' => 1,
                'quantity' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
                'sku_rule_group_id' => 1,
                'quantity_modifier' => 1,
                'sell_price' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

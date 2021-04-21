<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SkuRuleGroupSkusFixture
 */
class SkuRuleGroupSkusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'sku_rule_group_skus';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'sku_rule_group_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sage_itemcode' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_sku_rule_group_skus_sku_rule_groups' => ['type' => 'index', 'columns' => ['sku_rule_group_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_sku_rule_group_skus_sku_rule_groups' => ['type' => 'foreign', 'columns' => ['sku_rule_group_id'], 'references' => ['sku_rule_groups', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'sku_rule_group_id' => 1,
                'sage_itemcode' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

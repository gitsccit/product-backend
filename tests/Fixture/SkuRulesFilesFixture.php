<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SkuRulesFilesFixture
 */
class SkuRulesFilesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'sku_rule_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'file_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_sku_rules_files_sku_rules' => ['type' => 'index', 'columns' => ['sku_rule_id'], 'length' => []],
        ],
        '_constraints' => [
            'FK_sku_rules_files_sku_rules' => ['type' => 'foreign', 'columns' => ['sku_rule_id'], 'references' => ['sku_rules', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'sku_rule_id' => 1,
                'file_id' => 1,
            ],
        ];
        parent::init();
    }
}

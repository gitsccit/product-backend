<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitRuleDetailsFixture
 */
class KitRuleDetailsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'kit_rule_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'logic' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'relation' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'value' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'bucket_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'group_item_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sort' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_system_rule_details_group_items' => ['type' => 'index', 'columns' => ['group_item_id'], 'length' => []],
            'FK_system_rule_details_buckets' => ['type' => 'index', 'columns' => ['bucket_id'], 'length' => []],
            'FK_system_rule_details_system_rules' => ['type' => 'index', 'columns' => ['kit_rule_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_kit_rule_details_kit_rules' => ['type' => 'foreign', 'columns' => ['kit_rule_id'], 'references' => ['kit_rules', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_kit_rule_details_group_items' => ['type' => 'foreign', 'columns' => ['group_item_id'], 'references' => ['group_items', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_kit_rule_details_buckets' => ['type' => 'foreign', 'columns' => ['bucket_id'], 'references' => ['buckets', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
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
                'kit_rule_id' => 1,
                'logic' => 'Lorem ipsum dolor sit amet',
                'relation' => 'Lorem ipsum dolor sit amet',
                'value' => 1,
                'bucket_id' => 1,
                'group_item_id' => 1,
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpecificationsFixture
 */
class SpecificationsFixture extends TestFixture
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
        'specification_field_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sequence' => ['type' => 'tinyinteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'specification_unit_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'text_value' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'unit_value' => ['type' => 'float', 'length' => 10, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'sort' => ['type' => 'float', 'length' => 64, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'FK_specifications_products' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
            'FK_specifications_specification_fields' => ['type' => 'index', 'columns' => ['specification_field_id'], 'length' => []],
            'FK_specifications_specification_units' => ['type' => 'index', 'columns' => ['specification_unit_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_specifications_specification_units' => ['type' => 'foreign', 'columns' => ['specification_unit_id'], 'references' => ['specification_units', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'FK_specifications_specification_fields' => ['type' => 'foreign', 'columns' => ['specification_field_id'], 'references' => ['specification_fields', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_specifications_products' => ['type' => 'foreign', 'columns' => ['product_id'], 'references' => ['products', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'specification_field_id' => 1,
                'sequence' => 1,
                'specification_unit_id' => 1,
                'text_value' => 'Lorem ipsum dolor sit amet',
                'unit_value' => 1,
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}

<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RaidMapsFixture
 */
class RaidMapsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'product_category_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'device' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'interface' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'interface_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'interface2_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'raid_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ports_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'devices_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pergroup_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'capacity_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'backplane_spec_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_raid_maps_product_categories' => ['type' => 'index', 'columns' => ['product_category_id'], 'length' => []],
            'FK_raid_maps_specifications' => ['type' => 'index', 'columns' => ['interface_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_2' => ['type' => 'index', 'columns' => ['interface2_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_3' => ['type' => 'index', 'columns' => ['name_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_4' => ['type' => 'index', 'columns' => ['raid_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_5' => ['type' => 'index', 'columns' => ['ports_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_6' => ['type' => 'index', 'columns' => ['devices_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_7' => ['type' => 'index', 'columns' => ['pergroup_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_8' => ['type' => 'index', 'columns' => ['capacity_spec_id'], 'length' => []],
            'FK_raid_maps_specifications_9' => ['type' => 'index', 'columns' => ['backplane_spec_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_raid_maps_specifications_2' => ['type' => 'foreign', 'columns' => ['interface2_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications' => ['type' => 'foreign', 'columns' => ['interface_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_product_categories' => ['type' => 'foreign', 'columns' => ['product_category_id'], 'references' => ['product_categories', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications_9' => ['type' => 'foreign', 'columns' => ['backplane_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications_8' => ['type' => 'foreign', 'columns' => ['capacity_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications_7' => ['type' => 'foreign', 'columns' => ['pergroup_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications_6' => ['type' => 'foreign', 'columns' => ['devices_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications_5' => ['type' => 'foreign', 'columns' => ['ports_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications_4' => ['type' => 'foreign', 'columns' => ['raid_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'FK_raid_maps_specifications_3' => ['type' => 'foreign', 'columns' => ['name_spec_id'], 'references' => ['specifications', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'product_category_id' => 1,
                'device' => 'Lorem ipsum dolor sit amet',
                'interface' => 'Lorem ipsum dolor sit amet',
                'interface_spec_id' => 1,
                'interface2_spec_id' => 1,
                'name_spec_id' => 1,
                'raid_spec_id' => 1,
                'ports_spec_id' => 1,
                'devices_spec_id' => 1,
                'pergroup_spec_id' => 1,
                'capacity_spec_id' => 1,
                'backplane_spec_id' => 1,
            ],
        ];
        parent::init();
    }
}

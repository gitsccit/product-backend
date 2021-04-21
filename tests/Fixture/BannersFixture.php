<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BannersFixture
 */
class BannersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'image_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'app server files id', 'precision' => null, 'autoIncrement' => null],
        'tile_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => 'app server files id', 'precision' => null, 'autoIncrement' => null],
        'horizontal' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'left', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'vertical' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'middle', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'style' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'tworow', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'sort' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'timestamp' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'image_id' => 1,
                'tile_id' => 1,
                'horizontal' => 'Lorem ipsum dolor sit amet',
                'vertical' => 'Lorem ipsum dolor sit amet',
                'style' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'timestamp' => 1618931061,
            ],
        ];
        parent::init();
    }
}

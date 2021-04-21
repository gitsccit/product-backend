<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GalleriesFixture
 */
class GalleriesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'product_gallery_image_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'browse_gallery_image_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'system_gallery_image_id' => ['type' => 'integer', 'length' => null, 'unsigned' => true, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'FK_galleries_gallery_images' => ['type' => 'index', 'columns' => ['product_gallery_image_id'], 'length' => []],
            'FK_galleries_gallery_images_2' => ['type' => 'index', 'columns' => ['browse_gallery_image_id'], 'length' => []],
            'FK_galleries_gallery_images_3' => ['type' => 'index', 'columns' => ['system_gallery_image_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_galleries_gallery_images_3' => ['type' => 'foreign', 'columns' => ['system_gallery_image_id'], 'references' => ['gallery_images', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_galleries_gallery_images_2' => ['type' => 'foreign', 'columns' => ['browse_gallery_image_id'], 'references' => ['gallery_images', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
            'FK_galleries_gallery_images' => ['type' => 'foreign', 'columns' => ['product_gallery_image_id'], 'references' => ['gallery_images', 'id'], 'update' => 'cascade', 'delete' => 'setNull', 'length' => []],
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
                'product_gallery_image_id' => 1,
                'browse_gallery_image_id' => 1,
                'system_gallery_image_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}

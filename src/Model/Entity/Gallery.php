<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Gallery Entity
 *
 * @property int $id
 * @property int|null $product_gallery_image_id
 * @property int|null $browse_gallery_image_id
 * @property int|null $system_gallery_image_id
 * @property string $name
 *
 * @property \ProductBackend\Model\Entity\GalleryImage[] $gallery_images
 * @property \ProductBackend\Model\Entity\Product[] $products
 */
class Gallery extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'product_gallery_image_id' => true,
        'browse_gallery_image_id' => true,
        'system_gallery_image_id' => true,
        'name' => true,
        'gallery_images' => true,
        'products' => true,
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductPerspective Entity
 *
 * @property int $id
 * @property int $perspective_id
 * @property int $product_id
 * @property string|null $url
 * @property string|null $name
 * @property string|null $description
 * @property string|null $show_related_systems
 * @property string|null $active
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\Product $product
 */
class ProductPerspective extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'perspective_id' => true,
        'product_id' => true,
        'url' => true,
        'name' => true,
        'description' => true,
        'show_related_systems' => true,
        'active' => true,
        'perspective' => true,
        'product' => true,
    ];
}

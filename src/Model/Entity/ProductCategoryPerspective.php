<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductCategoryPerspective Entity
 *
 * @property int $id
 * @property int $perspective_id
 * @property int $product_category_id
 * @property string|null $url
 * @property string|null $name
 * @property string|null $description
 * @property string|null $active
 * @property string|null $show_related_systems
 * @property int|null $children
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\ProductCategory $product_category
 */
class ProductCategoryPerspective extends Entity
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
        'product_category_id' => true,
        'url' => true,
        'name' => true,
        'description' => true,
        'active' => true,
        'show_related_systems' => true,
        'children' => true,
        'perspective' => true,
        'product_category' => true,
    ];
}

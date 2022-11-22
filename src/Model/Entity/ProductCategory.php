<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductCategory Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $url
 * @property string $name
 * @property string $description
 * @property string|null $active
 * @property int $gallery_priority
 * @property string|null $show_related_systems
 * @property int $children
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\ProductCategory $parent_product_category
 * @property \ProductBackend\Model\Entity\ProductCategory[] $child_product_categories
 * @property \ProductBackend\Model\Entity\ProductCategoryPerspective[] $product_category_perspectives
 * @property \ProductBackend\Model\Entity\ProductCategoryRelation[] $product_category_relations
 * @property \ProductBackend\Model\Entity\Product[] $products
 * @property \ProductBackend\Model\Entity\RaidMap[] $raid_maps
 * @property \ProductBackend\Model\Entity\SpareCategoryRelation[] $spare_category_relations
 */
class ProductCategory extends Entity
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
        'parent_id' => true,
        'url' => true,
        'name' => true,
        'description' => true,
        'active' => true,
        'gallery_priority' => true,
        'show_related_systems' => true,
        'children' => true,
        'sort' => true,
        'parent_product_category' => true,
        'child_product_categories' => true,
        'product_category_perspectives' => true,
        'product_category_relations' => true,
        'products' => true,
        'raid_maps' => true,
        'spare_category_relations' => true,
    ];
}

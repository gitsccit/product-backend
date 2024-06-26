<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductCategoryRelation Entity
 *
 * @property int $product_category_id
 * @property int $related_product_category_id
 *
 * @property \ProductBackend\Model\Entity\ProductCategory $product_category
 */
class ProductCategoryRelation extends Entity
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
    protected array $_accessible = [
        'product_category_id' => true,
        'related_product_category_id' => true,
        'product_category' => true,
    ];
}

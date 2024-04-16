<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpareCategoryRelation Entity
 *
 * @property int $spare_category_id
 * @property int $product_category_id
 *
 * @property \ProductBackend\Model\Entity\SpareCategory $spare_category
 * @property \ProductBackend\Model\Entity\ProductCategory $product_category
 */
class SpareCategoryRelation extends Entity
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
        'spare_category_id' => true,
        'product_category_id' => true,
        'spare_category' => true,
        'product_category' => true,
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Spare Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $spare_category_id
 * @property int $related_id
 * @property string $active
 *
 * @property \ProductBackend\Model\Entity\Product $product
 * @property \ProductBackend\Model\Entity\SpareCategory $spare_category
 */
class Spare extends Entity
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
        'product_id' => true,
        'spare_category_id' => true,
        'related_id' => true,
        'active' => true,
        'product' => true,
        'spare_category' => true,
    ];
}

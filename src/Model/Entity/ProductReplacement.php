<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductReplacement Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $product_category_path
 * @property string|null $manufacturer
 * @property string|null $part_number
 * @property int|null $replacement_product_id
 *
 * @property \ProductBackend\Model\Entity\Product $product
 */
class ProductReplacement extends Entity
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
        'name' => true,
        'product_category_path' => true,
        'manufacturer' => true,
        'part_number' => true,
        'replacement_product_id' => true,
        'product' => true,
    ];
}

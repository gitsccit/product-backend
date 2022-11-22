<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductRule Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $logic
 * @property string|null $relation
 * @property int|null $quantity
 * @property string $condition
 * @property string|null $condition_relation
 * @property int|null $condition_quantity
 * @property string $action
 * @property string|null $description
 *
 * @property \ProductBackend\Model\Entity\Product[] $products
 */
class ProductRule extends Entity
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
        'name' => true,
        'logic' => true,
        'relation' => true,
        'quantity' => true,
        'condition' => true,
        'condition_relation' => true,
        'condition_quantity' => true,
        'action' => true,
        'description' => true,
        'products' => true,
    ];
}

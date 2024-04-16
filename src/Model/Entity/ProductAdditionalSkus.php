<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductAdditionalSkus Entity
 *
 * @property int $id
 * @property int|null $product_id
 * @property int $quantity
 * @property string|null $sage_itemcode
 * @property string|null $sage_comment
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\Product $product
 */
class ProductAdditionalSkus extends Entity
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
        'product_id' => true,
        'quantity' => true,
        'sage_itemcode' => true,
        'sage_comment' => true,
        'sort' => true,
        'product' => true,
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerBomDetail Entity
 *
 * @property int $id
 * @property int $customer_bom_id
 * @property int $sequence
 * @property int $option
 * @property string $sage_itemcode
 * @property int|null $quantity
 * @property string|null $comment
 * @property float $price
 *
 * @property \ProductBackend\Model\Entity\CustomerBom $customer_bom
 * @property \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[] $customer_bom_detail_additional_skus
 */
class CustomerBomDetail extends Entity
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
        'customer_bom_id' => true,
        'sequence' => true,
        'option' => true,
        'sage_itemcode' => true,
        'quantity' => true,
        'comment' => true,
        'price' => true,
        'customer_bom' => true,
        'customer_bom_detail_additional_skus' => true,
    ];
}

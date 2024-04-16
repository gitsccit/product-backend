<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerBomDetailAdditionalSkus Entity
 *
 * @property int $id
 * @property int $customer_bom_detail_id
 * @property string $sage_itemcode
 * @property int|null $quantity
 * @property string|null $comment
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\CustomerBomDetail $customer_bom_detail
 */
class CustomerBomDetailAdditionalSkus extends Entity
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
        'customer_bom_detail_id' => true,
        'sage_itemcode' => true,
        'quantity' => true,
        'comment' => true,
        'sort' => true,
        'customer_bom_detail' => true,
    ];
}

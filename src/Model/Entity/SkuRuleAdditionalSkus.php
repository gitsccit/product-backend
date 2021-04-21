<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SkuRuleAdditionalSkus Entity
 *
 * @property int $id
 * @property int|null $sku_rule_id
 * @property int|null $quantity
 * @property string $sage_itemcode
 * @property int|null $sku_rule_group_id
 * @property int|null $quantity_modifier
 * @property string $sell_price
 *
 * @property \ProductBackend\Model\Entity\SkuRule $sku_rule
 * @property \ProductBackend\Model\Entity\SkuRuleGroup $sku_rule_group
 */
class SkuRuleAdditionalSkus extends Entity
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
        'sku_rule_id' => true,
        'quantity' => true,
        'sage_itemcode' => true,
        'sku_rule_group_id' => true,
        'quantity_modifier' => true,
        'sell_price' => true,
        'sku_rule' => true,
        'sku_rule_group' => true,
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SkuRuleGroupSkus Entity
 *
 * @property int $id
 * @property int $sku_rule_group_id
 * @property string $sage_itemcode
 *
 * @property \ProductBackend\Model\Entity\SkuRuleGroup $sku_rule_group
 */
class SkuRuleGroupSkus extends Entity
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
        'sku_rule_group_id' => true,
        'sage_itemcode' => true,
        'sku_rule_group' => true,
    ];
}

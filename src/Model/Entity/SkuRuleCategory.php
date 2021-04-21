<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SkuRuleCategory Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SkuRuleCategory $parent_sku_rule_category
 * @property \ProductBackend\Model\Entity\SkuRuleCategory[] $child_sku_rule_categories
 * @property \ProductBackend\Model\Entity\SkuRule[] $sku_rules
 */
class SkuRuleCategory extends Entity
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
        'parent_id' => true,
        'name' => true,
        'sort' => true,
        'parent_sku_rule_category' => true,
        'child_sku_rule_categories' => true,
        'sku_rules' => true,
    ];
}

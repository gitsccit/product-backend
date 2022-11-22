<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SkuRule Entity
 *
 * @property int $id
 * @property int|null $sku_rule_category_id
 * @property string $name
 * @property string|null $scheduler_notes
 * @property int|null $sku_rule_group_id
 * @property string|null $eval_logic
 * @property int|null $eval_quantity
 * @property string $active
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SkuRuleCategory $sku_rule_category
 * @property \ProductBackend\Model\Entity\SkuRuleGroup[] $sku_rule_groups
 * @property \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[] $sku_rule_additional_skus
 * @property \ProductBackend\Model\Entity\SkuRulesFile[] $sku_rules_files
 */
class SkuRule extends Entity
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
        'sku_rule_category_id' => true,
        'name' => true,
        'scheduler_notes' => true,
        'sku_rule_group_id' => true,
        'eval_logic' => true,
        'eval_quantity' => true,
        'active' => true,
        'sort' => true,
        'sku_rule_category' => true,
        'sku_rule_groups' => true,
        'sku_rule_additional_skus' => true,
        'sku_rules_files' => true,
    ];
}

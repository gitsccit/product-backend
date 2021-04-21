<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SkuRuleGroup Entity
 *
 * @property int $id
 * @property int $sku_rule_id
 * @property string $method
 * @property int|null $spec_id
 * @property string|null $value
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SkuRule[] $sku_rules
 * @property \ProductBackend\Model\Entity\Spec $spec
 * @property \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[] $sku_rule_additional_skus
 * @property \ProductBackend\Model\Entity\SkuRuleGroupSkus[] $sku_rule_group_skus
 */
class SkuRuleGroup extends Entity
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
        'method' => true,
        'spec_id' => true,
        'value' => true,
        'sort' => true,
        'sku_rules' => true,
        'spec' => true,
        'sku_rule_additional_skus' => true,
        'sku_rule_group_skus' => true,
    ];
}

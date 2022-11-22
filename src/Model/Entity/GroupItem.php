<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupItem Entity
 *
 * @property int $id
 * @property int $group_id
 * @property int|null $product_id
 * @property int|null $system_id
 *
 * @property \ProductBackend\Model\Entity\Group $group
 * @property \ProductBackend\Model\Entity\Product $product
 * @property \ProductBackend\Model\Entity\System $system
 * @property \ProductBackend\Model\Entity\KitItem[] $kit_items
 * @property \ProductBackend\Model\Entity\KitRuleDetail[] $kit_rule_details
 */
class GroupItem extends Entity
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
        'group_id' => true,
        'product_id' => true,
        'system_id' => true,
        'group' => true,
        'product' => true,
        'system' => true,
        'kit_items' => true,
        'kit_rule_details' => true,
    ];
}

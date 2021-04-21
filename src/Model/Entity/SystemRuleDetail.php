<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SystemRuleDetail Entity
 *
 * @property int $id
 * @property int $system_rule_id
 * @property string $logic
 * @property string|null $relation
 * @property int|null $value
 * @property int|null $bucket_id
 * @property int|null $group_item_id
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SystemRule $system_rule
 * @property \ProductBackend\Model\Entity\Bucket $bucket
 * @property \ProductBackend\Model\Entity\GroupItem $group_item
 */
class SystemRuleDetail extends Entity
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
        'system_rule_id' => true,
        'logic' => true,
        'relation' => true,
        'value' => true,
        'bucket_id' => true,
        'group_item_id' => true,
        'sort' => true,
        'system_rule' => true,
        'bucket' => true,
        'group_item' => true,
    ];
}

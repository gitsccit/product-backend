<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SystemRule Entity
 *
 * @property int $id
 * @property int $system_id
 * @property string $name
 * @property string $action
 * @property string|null $description
 *
 * @property \ProductBackend\Model\Entity\System $system
 * @property \ProductBackend\Model\Entity\SystemRuleDetail[] $system_rule_details
 */
class SystemRule extends Entity
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
        'system_id' => true,
        'name' => true,
        'action' => true,
        'description' => true,
        'system' => true,
        'system_rule_details' => true,
    ];
}

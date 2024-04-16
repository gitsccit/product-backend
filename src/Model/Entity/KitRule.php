<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitRule Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property string $name
 * @property string $action
 * @property string|null $description
 *
 * @property \ProductBackend\Model\Entity\Kit $kit
 * @property \ProductBackend\Model\Entity\KitRuleDetail[] $kit_rule_details
 */
class KitRule extends Entity
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
        'kit_id' => true,
        'name' => true,
        'action' => true,
        'description' => true,
        'kit' => true,
        'kit_rule_details' => true,
    ];
}

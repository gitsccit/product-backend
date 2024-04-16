<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SystemReplacement Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $system_category_path
 * @property int|null $replacement_system_id
 *
 * @property \ProductBackend\Model\Entity\System $system
 */
class SystemReplacement extends Entity
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
        'name' => true,
        'system_category_path' => true,
        'replacement_system_id' => true,
        'system' => true,
    ];
}

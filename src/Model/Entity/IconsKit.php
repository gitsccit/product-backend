<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * IconsKit Entity
 *
 * @property int $icon_id
 * @property int $kit_id
 *
 * @property \ProductBackend\Model\Entity\Icon $icon
 * @property \ProductBackend\Model\Entity\Kit $kit
 */
class IconsKit extends Entity
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
        'icon_id' => true,
        'kit_id' => true,
        'icon' => true,
        'kit' => true,
    ];
}

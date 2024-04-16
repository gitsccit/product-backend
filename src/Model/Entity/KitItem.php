<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitItem Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property int $group_item_id
 * @property string $active
 *
 * @property \ProductBackend\Model\Entity\Kit $kit
 * @property \ProductBackend\Model\Entity\GroupItem $group_item
 * @property \ProductBackend\Model\Entity\KitOptionCodeItem[] $kit_option_code_items
 */
class KitItem extends Entity
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
        'group_item_id' => true,
        'active' => true,
        'kit' => true,
        'group_item' => true,
        'kit_option_code_items' => true,
    ];
}

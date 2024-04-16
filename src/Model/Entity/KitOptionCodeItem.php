<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitOptionCodeItem Entity
 *
 * @property int $id
 * @property int $kit_option_code_id
 * @property int $kit_item_id
 * @property int $position
 * @property string|null $part_number
 *
 * @property \ProductBackend\Model\Entity\KitOptionCode $kit_option_code
 * @property \ProductBackend\Model\Entity\KitItem $kit_item
 */
class KitOptionCodeItem extends Entity
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
        'kit_option_code_id' => true,
        'kit_item_id' => true,
        'position' => true,
        'part_number' => true,
        'kit_option_code' => true,
        'kit_item' => true,
    ];
}

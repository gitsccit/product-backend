<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitOptionCode Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property string $part_number
 * @property int $positions
 *
 * @property \ProductBackend\Model\Entity\Kit $kit
 * @property \ProductBackend\Model\Entity\KitOptionCodeItem[] $kit_option_code_items
 */
class KitOptionCode extends Entity
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
        'kit_id' => true,
        'part_number' => true,
        'positions' => true,
        'kit' => true,
        'kit_option_code_items' => true,
    ];
}

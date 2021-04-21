<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SystemItem Entity
 *
 * @property int $id
 * @property int $system_id
 * @property int $item_id
 * @property int $quantity
 *
 * @property \ProductBackend\Model\Entity\System $system
 * @property \ProductBackend\Model\Entity\GroupItem $group_item
 */
class SystemItem extends Entity
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
        'item_id' => true,
        'quantity' => true,
        'system' => true,
        'group_item' => true,
    ];
}

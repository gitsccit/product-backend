<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShipBoxesShipRate Entity
 *
 * @property int $ship_box_id
 * @property int $ship_rate_id
 *
 * @property \ProductBackend\Model\Entity\ShipBox $ship_box
 * @property \ProductBackend\Model\Entity\ShipRate $ship_rate
 */
class ShipBoxesShipRate extends Entity
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
        'ship_box_id' => true,
        'ship_rate_id' => true,
        'ship_box' => true,
        'ship_rate' => true,
    ];
}

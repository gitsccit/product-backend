<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShipRegion Entity
 *
 * @property int $id
 * @property string $name
 * @property string $ship_box_only
 *
 * @property \ProductBackend\Model\Entity\ShipRateShipRegionPrice[] $ship_rate_ship_region_prices
 * @property \ProductBackend\Model\Entity\ShipRegionLocation[] $ship_region_locations
 */
class ShipRegion extends Entity
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
        'name' => true,
        'ship_box_only' => true,
        'ship_rate_ship_region_prices' => true,
        'ship_region_locations' => true,
    ];
}

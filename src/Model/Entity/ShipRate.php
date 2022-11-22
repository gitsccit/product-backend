<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShipRate Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $sage_shipvia
 *
 * @property \ProductBackend\Model\Entity\ShipRateShipRegionPrice[] $ship_rate_ship_region_prices
 * @property \ProductBackend\Model\Entity\ShipBox[] $ship_boxes
 */
class ShipRate extends Entity
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
        'name' => true,
        'description' => true,
        'sage_shipvia' => true,
        'ship_rate_ship_region_prices' => true,
        'ship_boxes' => true,
    ];
}

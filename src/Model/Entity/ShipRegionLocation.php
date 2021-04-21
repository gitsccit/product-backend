<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShipRegionLocation Entity
 *
 * @property int $id
 * @property int $ship_region_id
 * @property string $country
 * @property string|null $state
 *
 * @property \ProductBackend\Model\Entity\ShipRegion $ship_region
 */
class ShipRegionLocation extends Entity
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
        'ship_region_id' => true,
        'country' => true,
        'state' => true,
        'ship_region' => true,
    ];
}

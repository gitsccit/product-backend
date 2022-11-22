<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * RaidMap Entity
 *
 * @property int $id
 * @property int|null $product_category_id
 * @property string $device
 * @property string|null $interface
 * @property int|null $interface_spec_id
 * @property int|null $interface2_spec_id
 * @property int|null $name_spec_id
 * @property int|null $raid_spec_id
 * @property int|null $ports_spec_id
 * @property int|null $devices_spec_id
 * @property int|null $pergroup_spec_id
 * @property int|null $capacity_spec_id
 * @property int|null $backplane_spec_id
 *
 * @property \ProductBackend\Model\Entity\ProductCategory $product_category
 * @property \ProductBackend\Model\Entity\Specification $specification
 */
class RaidMap extends Entity
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
        'product_category_id' => true,
        'device' => true,
        'interface' => true,
        'interface_spec_id' => true,
        'interface2_spec_id' => true,
        'name_spec_id' => true,
        'raid_spec_id' => true,
        'ports_spec_id' => true,
        'devices_spec_id' => true,
        'pergroup_spec_id' => true,
        'capacity_spec_id' => true,
        'backplane_spec_id' => true,
        'product_category' => true,
        'specification' => true,
    ];
}

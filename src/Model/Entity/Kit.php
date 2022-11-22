<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Kit Entity
 *
 * @property int $id
 * @property string $name
 * @property int $build_time
 * @property string $sage_itemcode
 * @property string $product_rules
 * @property string $sku_rules
 * @property string $noise_level
 * @property string $power_estimate
 * @property string $pallet_ship
 * @property string|null $spares_kit
 * @property int|null $ship_from_id
 * @property int|null $ship_box_id
 * @property float|null $length
 * @property float|null $width
 * @property float|null $height
 * @property string $active
 * @property \Cake\I18n\FrozenTime $date_added
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\Location $location
 * @property \ProductBackend\Model\Entity\ShipBox $ship_box
 * @property \ProductBackend\Model\Entity\KitBucket[] $kit_buckets
 * @property \ProductBackend\Model\Entity\KitItem[] $kit_items
 * @property \ProductBackend\Model\Entity\KitOptionCode[] $kit_option_codes
 * @property \ProductBackend\Model\Entity\KitRule[] $kit_rules
 * @property \ProductBackend\Model\Entity\System[] $systems
 * @property \ProductBackend\Model\Entity\Icon[] $icons
 * @property \ProductBackend\Model\Entity\Plugin[] $plugins
 * @property \ProductBackend\Model\Entity\Tag[] $tags
 */
class Kit extends Entity
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
        'build_time' => true,
        'sage_itemcode' => true,
        'product_rules' => true,
        'sku_rules' => true,
        'noise_level' => true,
        'power_estimate' => true,
        'pallet_ship' => true,
        'spares_kit' => true,
        'ship_from_id' => true,
        'ship_box_id' => true,
        'length' => true,
        'width' => true,
        'height' => true,
        'active' => true,
        'date_added' => true,
        'timestamp' => true,
        'location' => true,
        'ship_box' => true,
        'kit_buckets' => true,
        'kit_items' => true,
        'kit_option_codes' => true,
        'kit_rules' => true,
        'systems' => true,
        'icons' => true,
        'plugins' => true,
        'tags' => true,
    ];
}

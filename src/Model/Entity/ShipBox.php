<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShipBox Entity
 *
 * @property int $id
 * @property string $name
 * @property float|null $length
 * @property float|null $width
 * @property float|null $height
 *
 * @property \ProductBackend\Model\Entity\Kit[] $kits
 * @property \ProductBackend\Model\Entity\Product[] $products
 * @property \ProductBackend\Model\Entity\ShipRate[] $ship_rates
 */
class ShipBox extends Entity
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
        'length' => true,
        'width' => true,
        'height' => true,
        'kits' => true,
        'products' => true,
        'ship_rates' => true,
    ];
}

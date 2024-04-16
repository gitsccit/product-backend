<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Manufacturer Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $countryoforigin_id
 * @property int|null $image_id
 *
 * @property \ProductBackend\Model\Entity\Location $location
 * @property \ProductBackend\Model\Entity\Product[] $products
 */
class Manufacturer extends Entity
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
        'name' => true,
        'countryoforigin_id' => true,
        'image_id' => true,
        'location' => true,
        'products' => true,
    ];
}

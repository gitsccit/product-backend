<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerBom Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int|null $customer_category_id
 * @property string $name
 * @property string|null $description
 * @property int|null $location_id
 * @property int|null $image_id
 * @property string $bstock
 * @property float $price
 * @property string $palletship
 * @property float $weight
 * @property float $length
 * @property float $width
 * @property float $height
 * @property string|null $active
 * @property \Cake\I18n\FrozenTime $date_added
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\Customer $customer
 * @property \ProductBackend\Model\Entity\CustomerCategory $customer_category
 * @property \ProductBackend\Model\Entity\Location $location
 * @property \ProductBackend\Model\Entity\Image $image
 * @property \ProductBackend\Model\Entity\CustomerBomDetail[] $customer_bom_details
 */
class CustomerBom extends Entity
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
        'customer_id' => true,
        'customer_category_id' => true,
        'name' => true,
        'description' => true,
        'location_id' => true,
        'image_id' => true,
        'bstock' => true,
        'price' => true,
        'palletship' => true,
        'weight' => true,
        'length' => true,
        'width' => true,
        'height' => true,
        'active' => true,
        'date_added' => true,
        'timestamp' => true,
        'customer' => true,
        'customer_category' => true,
        'location' => true,
        'image' => true,
        'customer_bom_details' => true,
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * PriceLevel Entity
 *
 * @property int $id
 * @property string $name
 * @property int $markup
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\PriceLevelPerspective[] $price_level_perspectives
 * @property \ProductBackend\Model\Entity\ProductPriceLevel[] $product_price_levels
 * @property \ProductBackend\Model\Entity\SystemPriceLevel[] $system_price_levels
 */
class PriceLevel extends Entity
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
        'markup' => true,
        'sort' => true,
        'price_level_perspectives' => true,
        'product_price_levels' => true,
        'system_price_levels' => true,
    ];
}

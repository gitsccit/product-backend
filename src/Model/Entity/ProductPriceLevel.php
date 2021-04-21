<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductPriceLevel Entity
 *
 * @property int $id
 * @property int|null $price_level_id
 * @property int|null $product_id
 * @property string $logic
 * @property float|null $value
 * @property float $price
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\PriceLevel $price_level
 * @property \ProductBackend\Model\Entity\Product $product
 */
class ProductPriceLevel extends Entity
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
        'price_level_id' => true,
        'product_id' => true,
        'logic' => true,
        'value' => true,
        'price' => true,
        'timestamp' => true,
        'price_level' => true,
        'product' => true,
    ];
}

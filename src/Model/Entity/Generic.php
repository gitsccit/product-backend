<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Generic Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $sage_itemcode
 * @property float $cost
 * @property string $cost_maintenance
 * @property string $prioritize
 * @property \Cake\I18n\FrozenTime $date_added
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\Product[] $products
 */
class Generic extends Entity
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
        'product_id' => true,
        'sage_itemcode' => true,
        'cost' => true,
        'cost_maintenance' => true,
        'prioritize' => true,
        'date_added' => true,
        'timestamp' => true,
        'products' => true,
    ];
}

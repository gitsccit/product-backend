<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerProduct Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int|null $customer_category_id
 * @property int|null $product_id
 * @property string|null $sage_itemcode
 * @property string|null $notes
 * @property string $show_stock
 * @property string $active
 * @property \Cake\I18n\FrozenTime $date_added
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\Customer $customer
 * @property \ProductBackend\Model\Entity\CustomerCategory $customer_category
 * @property \ProductBackend\Model\Entity\Product $product
 */
class CustomerProduct extends Entity
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
        'customer_id' => true,
        'customer_category_id' => true,
        'product_id' => true,
        'sage_itemcode' => true,
        'notes' => true,
        'show_stock' => true,
        'active' => true,
        'date_added' => true,
        'timestamp' => true,
        'customer' => true,
        'customer_category' => true,
        'product' => true,
    ];
}

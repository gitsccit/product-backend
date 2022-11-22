<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerCategory Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $customer_id
 * @property string $active
 * @property int $children
 * @property string $name
 *
 * @property \ProductBackend\Model\Entity\ParentCustomerCategory $parent_customer_category
 * @property \ProductBackend\Model\Entity\Customer $customer
 * @property \ProductBackend\Model\Entity\CustomerBom[] $customer_boms
 * @property \ProductBackend\Model\Entity\ChildCustomerCategory[] $child_customer_categories
 * @property \ProductBackend\Model\Entity\CustomerProduct[] $customer_products
 */
class CustomerCategory extends Entity
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
        'parent_id' => true,
        'customer_id' => true,
        'active' => true,
        'children' => true,
        'name' => true,
        'parent_customer_category' => true,
        'customer' => true,
        'customer_boms' => true,
        'child_customer_categories' => true,
        'customer_products' => true,
    ];
}

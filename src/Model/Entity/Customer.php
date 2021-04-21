<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property int|null $perspective_id
 * @property string $name
 * @property int|null $crm_account
 * @property string|null $sage_customer
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\CustomerBom[] $customer_boms
 * @property \ProductBackend\Model\Entity\CustomerCategory[] $customer_categories
 * @property \ProductBackend\Model\Entity\CustomerProduct[] $customer_products
 */
class Customer extends Entity
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
        'perspective_id' => true,
        'name' => true,
        'crm_account' => true,
        'sage_customer' => true,
        'perspective' => true,
        'customer_boms' => true,
        'customer_categories' => true,
        'customer_products' => true,
    ];
}

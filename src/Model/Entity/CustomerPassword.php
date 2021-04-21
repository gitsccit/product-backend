<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerPassword Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property string|null $password
 * @property string|null $algorithm
 * @property \Cake\I18n\FrozenTime $date_created
 *
 * @property \ProductBackend\Model\Entity\Customer $customer
 */
class CustomerPassword extends Entity
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
        'password' => true,
        'algorithm' => true,
        'date_created' => true,
        'customer' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $postal_code
 * @property string $country_code
 * @property string|null $sage_warehouse_code
 *
 * @property \ProductBackend\Model\Entity\CustomerBom[] $customer_boms
 */
class Location extends Entity
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
        'postal_code' => true,
        'country_code' => true,
        'sage_warehouse_code' => true,
        'customer_boms' => true,
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * GenericsProduct Entity
 *
 * @property int $generic_id
 * @property int $product_id
 *
 * @property \ProductBackend\Model\Entity\Generic $generic
 * @property \ProductBackend\Model\Entity\Product $product
 */
class GenericsProduct extends Entity
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
        'generic_id' => true,
        'product_id' => true,
        'generic' => true,
        'product' => true,
    ];
}

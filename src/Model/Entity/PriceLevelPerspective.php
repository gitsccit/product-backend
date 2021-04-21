<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * PriceLevelPerspective Entity
 *
 * @property int $id
 * @property int $perspective_id
 * @property int $price_level_id
 * @property string $active
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\PriceLevel $price_level
 */
class PriceLevelPerspective extends Entity
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
        'price_level_id' => true,
        'active' => true,
        'perspective' => true,
        'price_level' => true,
    ];
}

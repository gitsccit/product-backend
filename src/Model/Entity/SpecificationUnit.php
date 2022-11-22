<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpecificationUnit Entity
 *
 * @property int $id
 * @property int $specification_unit_group_id
 * @property string $symbol
 * @property string $name
 * @property string $description
 * @property string $multiplier
 *
 * @property \ProductBackend\Model\Entity\SpecificationUnitGroup $specification_unit_group
 * @property \ProductBackend\Model\Entity\Specification[] $specifications
 */
class SpecificationUnit extends Entity
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
        'specification_unit_group_id' => true,
        'symbol' => true,
        'name' => true,
        'description' => true,
        'multiplier' => true,
        'specification_unit_group' => true,
        'specifications' => true,
    ];
}

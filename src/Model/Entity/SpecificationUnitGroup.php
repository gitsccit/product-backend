<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpecificationUnitGroup Entity
 *
 * @property int $id
 * @property string $name
 *
 * @property \ProductBackend\Model\Entity\SpecificationField[] $specification_fields
 * @property \ProductBackend\Model\Entity\SpecificationUnit[] $specification_units
 */
class SpecificationUnitGroup extends Entity
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
        'name' => true,
        'specification_fields' => true,
        'specification_units' => true,
    ];
}

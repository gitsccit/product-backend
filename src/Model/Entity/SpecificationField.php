<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpecificationField Entity
 *
 * @property int $id
 * @property int|null $specification_group_id
 * @property int|null $specification_unit_group_id
 * @property string $techspec
 * @property string $name
 * @property string $label
 * @property string $description
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SpecificationGroup $specification_group
 * @property \ProductBackend\Model\Entity\SpecificationUnitGroup $specification_unit_group
 * @property \ProductBackend\Model\Entity\Specification[] $specifications
 */
class SpecificationField extends Entity
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
        'specification_group_id' => true,
        'specification_unit_group_id' => true,
        'techspec' => true,
        'name' => true,
        'label' => true,
        'description' => true,
        'sort' => true,
        'specification_group' => true,
        'specification_unit_group' => true,
        'specifications' => true,
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpecificationGroup Entity
 *
 * @property int $id
 * @property string $name
 * @property string $reserved
 * @property string $description
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SpecificationField[] $specification_fields
 */
class SpecificationGroup extends Entity
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
        'reserved' => true,
        'description' => true,
        'sort' => true,
        'specification_fields' => true,
    ];
}

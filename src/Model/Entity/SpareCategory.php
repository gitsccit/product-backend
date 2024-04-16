<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpareCategory Entity
 *
 * @property int $id
 * @property string $name
 * @property int $quantity
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SpareCategoryRelation[] $spare_category_relations
 * @property \ProductBackend\Model\Entity\Spare[] $spares
 */
class SpareCategory extends Entity
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
        'quantity' => true,
        'sort' => true,
        'spare_category_relations' => true,
        'spares' => true,
    ];
}

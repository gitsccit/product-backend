<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Specification Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $specification_field_id
 * @property int $sequence
 * @property int|null $specification_unit_id
 * @property string $text_value
 * @property float|null $unit_value
 * @property float|null $sort
 *
 * @property \ProductBackend\Model\Entity\Product $product
 * @property \ProductBackend\Model\Entity\SpecificationField $specification_field
 * @property \ProductBackend\Model\Entity\SpecificationUnit $specification_unit
 */
class Specification extends Entity
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
        'product_id' => true,
        'specification_field_id' => true,
        'sequence' => true,
        'specification_unit_id' => true,
        'text_value' => true,
        'unit_value' => true,
        'sort' => true,
        'product' => true,
        'specification_field' => true,
        'specification_unit' => true,
    ];
}

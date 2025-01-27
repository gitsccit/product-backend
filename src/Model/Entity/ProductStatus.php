<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductStatus Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $warning
 * @property string|null $sowg
 * @property int $sort
 */
class ProductStatus extends Entity
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
        'warning' => true,
        'sowg' => true,
        'sort' => true,
    ];
}

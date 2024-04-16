<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * TagCategory Entity
 *
 * @property int $id
 * @property string $name
 *
 * @property \ProductBackend\Model\Entity\TagGroup[] $tag_groups
 */
class TagCategory extends Entity
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
        'tag_groups' => true,
    ];
}

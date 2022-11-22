<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * TagGroup Entity
 *
 * @property int $id
 * @property string $name
 * @property string $display_value
 *
 * @property \ProductBackend\Model\Entity\Tag[] $tags
 * @property \ProductBackend\Model\Entity\TagCategory[] $tag_categories
 */
class TagGroup extends Entity
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
        'name' => true,
        'display_value' => true,
        'tags' => true,
        'tag_categories' => true,
    ];
}

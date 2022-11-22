<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * TagCategoriesTagGroup Entity
 *
 * @property int $id
 * @property int $tag_category_id
 * @property int $tag_group_id
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\TagCategory $tag_category
 * @property \ProductBackend\Model\Entity\TagGroup $tag_group
 */
class TagCategoriesTagGroup extends Entity
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
        'tag_category_id' => true,
        'tag_group_id' => true,
        'sort' => true,
        'tag_category' => true,
        'tag_group' => true,
    ];
}

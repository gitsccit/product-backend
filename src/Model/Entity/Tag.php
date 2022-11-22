<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tag Entity
 *
 * @property int $id
 * @property int|null $tag_group_id
 * @property string $name
 * @property int|null $image_id
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\TagGroup $tag_group
 * @property \ProductBackend\Model\Entity\Kit[] $kits
 */
class Tag extends Entity
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
        'tag_group_id' => true,
        'name' => true,
        'image_id' => true,
        'sort' => true,
        'tag_group' => true,
        'kits' => true,
    ];

    protected $_hidden = [
        '_joinData'
    ];
}

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * TagCategory Entity
 *
 * @property int $id
 * @property string $name
 * @property string $filter
 * @property int|null $filter_sequence
 * @property string $support
 * @property string $support_text
 * @property int|null $support_sequence
 *
 * @property \ProductBackend\Model\Entity\Tag[] $tags
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
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'filter' => true,
        'filter_sequence' => true,
        'support' => true,
        'support_text' => true,
        'support_sequence' => true,
        'tags' => true,
    ];
}

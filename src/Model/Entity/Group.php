<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Group Entity
 *
 * @property int $id
 * @property string $name
 * @property string $method
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\GroupItem[] $group_items
 * @property \ProductBackend\Model\Entity\Bucket[] $buckets
 */
class Group extends Entity
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
        'method' => true,
        'sort' => true,
        'group_items' => true,
        'buckets' => true,
    ];
}

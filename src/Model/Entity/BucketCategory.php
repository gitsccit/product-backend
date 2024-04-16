<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * BucketCategory Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $tab_id
 * @property string $name
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\ParentBucketCategory $parent_bucket_category
 * @property \ProductBackend\Model\Entity\Tab $tab
 * @property \ProductBackend\Model\Entity\ChildBucketCategory[] $child_bucket_categories
 * @property \ProductBackend\Model\Entity\Bucket[] $buckets
 */
class BucketCategory extends Entity
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
        'parent_id' => true,
        'tab_id' => true,
        'name' => true,
        'sort' => true,
        'parent_bucket_category' => true,
        'tab' => true,
        'child_bucket_categories' => true,
        'buckets' => true,
    ];
}

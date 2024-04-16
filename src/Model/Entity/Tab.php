<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tab Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $file_id
 * @property int|null $plugin_id
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\File $file
 * @property \ProductBackend\Model\Entity\Plugin $plugin
 * @property \ProductBackend\Model\Entity\BucketCategory[] $bucket_categories
 * @property \ProductBackend\Model\Entity\Bucket[] $buckets
 * @property \ProductBackend\Model\Entity\TabPerspective[] $tab_perspectives
 */
class Tab extends Entity
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
        'description' => true,
        'file_id' => true,
        'plugin_id' => true,
        'sort' => true,
        'file' => true,
        'plugin' => true,
        'bucket_categories' => true,
        'buckets' => true,
        'tab_perspectives' => true,
    ];
}

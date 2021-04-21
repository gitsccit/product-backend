<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bucket Entity
 *
 * @property int $id
 * @property int $bucket_category_id
 * @property int|null $tab_id
 * @property int|null $plugin_id
 * @property string|null $name
 * @property string $description
 * @property string $multiple
 * @property string $hidden
 * @property string $compare
 * @property string|null $notes
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\BucketCategory $bucket_category
 * @property \ProductBackend\Model\Entity\Tab $tab
 * @property \ProductBackend\Model\Entity\Plugin $plugin
 * @property \ProductBackend\Model\Entity\KitBucket[] $kit_buckets
 * @property \ProductBackend\Model\Entity\KitRuleDetail[] $kit_rule_details
 * @property \ProductBackend\Model\Entity\Group[] $groups
 */
class Bucket extends Entity
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
        'bucket_category_id' => true,
        'tab_id' => true,
        'plugin_id' => true,
        'name' => true,
        'description' => true,
        'multiple' => true,
        'hidden' => true,
        'compare' => true,
        'notes' => true,
        'sort' => true,
        'bucket_category' => true,
        'tab' => true,
        'plugin' => true,
        'kit_buckets' => true,
        'kit_rule_details' => true,
        'groups' => true,
    ];
}

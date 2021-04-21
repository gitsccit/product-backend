<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * BucketsGroup Entity
 *
 * @property int $bucket_id
 * @property int $group_id
 *
 * @property \ProductBackend\Model\Entity\Bucket $bucket
 * @property \ProductBackend\Model\Entity\Group $group
 */
class BucketsGroup extends Entity
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
        'bucket_id' => true,
        'group_id' => true,
        'bucket' => true,
        'group' => true,
    ];
}

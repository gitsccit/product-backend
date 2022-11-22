<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitBucket Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property int $bucket_id
 * @property string $quantity
 * @property int|null $minqty
 * @property int|null $maxqty
 * @property string|null $notes
 *
 * @property \ProductBackend\Model\Entity\Kit $kit
 * @property \ProductBackend\Model\Entity\Bucket $bucket
 */
class KitBucket extends Entity
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
        'kit_id' => true,
        'bucket_id' => true,
        'quantity' => true,
        'minqty' => true,
        'maxqty' => true,
        'notes' => true,
        'kit' => true,
        'bucket' => true,
    ];
}

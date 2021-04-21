<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * GalleryImage Entity
 *
 * @property int $id
 * @property int $gallery_id
 * @property int $file_id
 * @property string $active
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\Gallery $gallery
 * @property \ProductBackend\Model\Entity\File $file
 */
class GalleryImage extends Entity
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
        'gallery_id' => true,
        'file_id' => true,
        'active' => true,
        'sort' => true,
        'gallery' => true,
        'file' => true,
    ];
}

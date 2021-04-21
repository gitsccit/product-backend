<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * TabPerspective Entity
 *
 * @property int $id
 * @property int $perspective_id
 * @property int $tab_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $file_id
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\Tab $tab
 * @property \ProductBackend\Model\Entity\File $file
 */
class TabPerspective extends Entity
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
        'perspective_id' => true,
        'tab_id' => true,
        'name' => true,
        'description' => true,
        'file_id' => true,
        'perspective' => true,
        'tab' => true,
        'file' => true,
    ];
}

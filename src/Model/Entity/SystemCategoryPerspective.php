<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SystemCategoryPerspective Entity
 *
 * @property int $id
 * @property int $perspective_id
 * @property int $system_category_id
 * @property string|null $url
 * @property string|null $name
 * @property string|null $description
 * @property int|null $banner_id
 * @property string|null $active
 * @property int|null $children
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\SystemCategory $system_category
 * @property \ProductBackend\Model\Entity\Banner $banner
 */
class SystemCategoryPerspective extends Entity
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
        'perspective_id' => true,
        'system_category_id' => true,
        'url' => true,
        'name' => true,
        'description' => true,
        'banner_id' => true,
        'active' => true,
        'children' => true,
        'perspective' => true,
        'system_category' => true,
        'banner' => true,
    ];
}

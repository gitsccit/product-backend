<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SystemPerspective Entity
 *
 * @property int $id
 * @property int $perspective_id
 * @property int $system_id
 * @property string|null $price_lock
 * @property string|null $url
 * @property string|null $name
 * @property string|null $name_line_1
 * @property string|null $name_line_2
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string|null $category_browse
 * @property string|null $active
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\System $system
 */
class SystemPerspective extends Entity
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
        'perspective_id' => true,
        'system_id' => true,
        'price_lock' => true,
        'url' => true,
        'name' => true,
        'name_line_1' => true,
        'name_line_2' => true,
        'description' => true,
        'meta_title' => true,
        'meta_keywords' => true,
        'meta_description' => true,
        'category_browse' => true,
        'active' => true,
        'perspective' => true,
        'system' => true,
    ];
}

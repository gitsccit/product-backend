<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * PluginPerspective Entity
 *
 * @property int $id
 * @property int $perspective_id
 * @property int $plugin_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $active
 *
 * @property \ProductBackend\Model\Entity\Perspective $perspective
 * @property \ProductBackend\Model\Entity\Plugin $plugin
 */
class PluginPerspective extends Entity
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
        'plugin_id' => true,
        'name' => true,
        'description' => true,
        'active' => true,
        'perspective' => true,
        'plugin' => true,
    ];
}

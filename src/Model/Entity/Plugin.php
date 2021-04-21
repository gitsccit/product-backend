<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Plugin Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $include
 * @property string|null $active
 *
 * @property \ProductBackend\Model\Entity\Bucket[] $buckets
 * @property \ProductBackend\Model\Entity\PluginPerspective[] $plugin_perspectives
 * @property \ProductBackend\Model\Entity\Tab[] $tabs
 * @property \ProductBackend\Model\Entity\Kit[] $kits
 */
class Plugin extends Entity
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
        'name' => true,
        'description' => true,
        'include' => true,
        'active' => true,
        'buckets' => true,
        'plugin_perspectives' => true,
        'tabs' => true,
        'kits' => true,
    ];
}

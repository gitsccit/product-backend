<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Perspective Entity
 *
 * @property int $id
 * @property string $name
 * @property string $active
 * @property string $type
 *
 * @property \ProductBackend\Model\Entity\Customer[] $customers
 * @property \ProductBackend\Model\Entity\PluginPerspective[] $plugin_perspectives
 * @property \ProductBackend\Model\Entity\PriceLevelPerspective[] $price_level_perspectives
 * @property \ProductBackend\Model\Entity\ProductCategoryPerspective[] $product_category_perspectives
 * @property \ProductBackend\Model\Entity\ProductPerspective[] $product_perspectives
 * @property \ProductBackend\Model\Entity\SystemCategoryPerspective[] $system_category_perspectives
 * @property \ProductBackend\Model\Entity\SystemPerspective[] $system_perspectives
 * @property \ProductBackend\Model\Entity\TabPerspective[] $tab_perspectives
 */
class Perspective extends Entity
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
        'active' => true,
        'type' => true,
        'customers' => true,
        'plugin_perspectives' => true,
        'price_level_perspectives' => true,
        'product_category_perspectives' => true,
        'product_perspectives' => true,
        'system_category_perspectives' => true,
        'system_perspectives' => true,
        'tab_perspectives' => true,
    ];
}

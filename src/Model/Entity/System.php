<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\Datasource\FactoryLocator;
use Cake\ORM\Entity;

/**
 * System Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property int|null $system_category_id
 * @property string $configurable
 * @property float|null $cost
 * @property string $price_lock
 * @property string $url
 * @property string $name
 * @property string $name_line_1
 * @property string $name_line_2
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $force_perspective
 * @property string $category_browse
 * @property string $active
 * @property int $sort
 * @property \Cake\I18n\FrozenTime $date_added
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\Kit $kit
 * @property \ProductBackend\Model\Entity\SystemCategory $system_category
 * @property \ProductBackend\Model\Entity\GroupItem[] $group_items
 * @property \ProductBackend\Model\Entity\SystemItem[] $system_items
 * @property \ProductBackend\Model\Entity\SystemPerspective[] $system_perspectives
 * @property \ProductBackend\Model\Entity\SystemPriceLevel[] $system_price_levels
 */
class System extends Entity
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
        'kit_id' => true,
        'system_category_id' => true,
        'configurable' => true,
        'cost' => true,
        'price_lock' => true,
        'url' => true,
        'name' => true,
        'name_line_1' => true,
        'name_line_2' => true,
        'description' => true,
        'meta_title' => true,
        'meta_keywords' => true,
        'meta_description' => true,
        'force_perspective' => true,
        'category_browse' => true,
        'active' => true,
        'sort' => true,
        'date_added' => true,
        'timestamp' => true,
        'kit' => true,
        'system_category' => true,
        'group_items' => true,
        'system_items' => true,
        'system_perspectives' => true,
        'system_price_levels' => true,
    ];

    public function getBreadcrumbs()
    {
        if (!isset($this->system_category)) {
            $this->system_category = FactoryLocator::get('Table')->get('ProductBackend.SystemCategories')
                ->get($this->system_category_id);
        }

        $breadcrumbs = $this->system_category->getBreadcrumbs();
        $breadcrumbs[] = [
            'title' => $this->name,
            'url' => "/system/$this->url",
        ];

        return $breadcrumbs;
    }
}

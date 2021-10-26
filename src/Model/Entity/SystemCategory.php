<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\Datasource\FactoryLocator;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Entity;

/**
 * SystemCategory Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $url
 * @property string $name
 * @property string $description
 * @property int|null $force_perspective
 * @property int|null $banner_id
 * @property string $spares_kits
 * @property string $active
 * @property int $children
 * @property int $sort
 *
 * @property \ProductBackend\Model\Entity\SystemCategory $parent_system_category
 * @property \ProductBackend\Model\Entity\Banner $banner
 * @property \ProductBackend\Model\Entity\SystemCategory[] $child_system_categories
 * @property \ProductBackend\Model\Entity\SystemCategoryPerspective[] $system_category_perspectives
 * @property \ProductBackend\Model\Entity\System[] $systems
 */
class SystemCategory extends Entity
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
        'parent_id' => true,
        'url' => true,
        'name' => true,
        'description' => true,
        'force_perspective' => true,
        'banner_id' => true,
        'spares_kits' => true,
        'active' => true,
        'children' => true,
        'sort' => true,
        'parent_system_category' => true,
        'banner' => true,
        'child_system_categories' => true,
        'system_category_perspectives' => true,
        'systems' => true,
    ];

    public function loadSystems($count = 4)
    {
        $currentSystemCount = count($this->systems ?? []);

        $this->systems = FactoryLocator::get('Table')->get('ProductBackend.Systems')->find('listing')
            ->where(['Systems.system_category_id' => $this->id])->limit($count - $currentSystemCount)->all()->toList();

        foreach ($this->children ?? $this->child_system_categories as $childCategory) {
            $currentSystemCount = count($this->products ?? []);

            if ($currentSystemCount < $count) {
                $childCategory->loadSystems($count - $currentSystemCount);
                $this->systems = array_merge($this->systems, $childCategory->systems);
            }
        }
    }

    public static function getBreadcrumbBase()
    {
        return [
            [
                'title' => 'Systems',
                'url' => '/systems',
            ],
        ];
    }

    public function getBreadcrumbs()
    {
        if ($this->parent_id && !isset($this->parent_system_category)) {
            $this->parent_system_category = FactoryLocator::get('Table')->get('ProductBackend.SystemCategories')
                ->get($this->parent_id, ['finder' => 'listing']);

            if (is_null($this->parent_system_category)) {
                throw new NotFoundException();
            }

            $breadcrumbs = $this->parent_system_category->getBreadcrumbs();
        }

        if (!isset($breadcrumbs)) {
            $breadcrumbs = SystemCategory::getBreadcrumbBase();
        }

        $parentCrumb = end($breadcrumbs);

        $breadcrumbs[] = [
            'title' => $this->name,
            'url' => "$parentCrumb[url]/$this->url",
        ];

        return $breadcrumbs;
    }
}

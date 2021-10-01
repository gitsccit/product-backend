<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Datasource\FactoryLocator;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

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

    public function getBreadcrumbs($configID = null)
    {
        if (!isset($this->system_category)) {
            $this->system_category = FactoryLocator::get('Table')->get('ProductBackend.SystemCategories')
                ->get($this->system_category_id);
        }

        $breadcrumbs = $this->system_category->getBreadcrumbs();
        $breadcrumbs[] = [
            'title' => $this->name,
            'url' => "/system/$this->url" . ($configID ? "/$configID" : ''),
        ];

        return $breadcrumbs;
    }

    public function loadConfiguration($configJson = null)
    {
        if ($configJson) {
            $selectedItems = array_merge(...$configJson['config']);
            $subKitItems = array_filter($selectedItems, function ($selectedItem) {
                return isset($selectedItem['subkit']);
            });

            [$cost, $price] = TableRegistry::getTableLocator()->get('ProductBackend.Systems')
                ->getConfigurationCostAndPrice($configJson, ['systemID' => $this['id']]);

            if (count($subKitItems) > 0) {
                $allItems = Hash::combine($this['buckets'], '{n}.groups.{n}.group_items.{n}.id',
                    '{n}.groups.{n}.group_items.{n}');

                // fill in sub-kits' details
                $subKitConfigItemIDs = array_unique(Hash::extract($subKitItems, '{n}.subkit.config.{n}.{n}.item_id'));
                $subKitConfigItems = TableRegistry::getTableLocator()->get('ProductBackend.GroupItems')
                    ->find('configuration')
                    ->whereInList('GroupItems.id', $subKitConfigItemIDs)
                    ->indexBy('id')
                    ->toArray();

                $subKits = array_map(function ($subKitLine) use ($allItems, $subKitConfigItems) {
                    $subKit = $subKitLine['subkit'];

                    [$cost, $price] = TableRegistry::getTableLocator()->get('ProductBackend.Systems')
                        ->getConfigurationCostAndPrice($subKit);

                    $formattedSubKit = array_merge($allItems[$subKitLine['item_id']], [
                        'config_name' => $subKit['name'],
                        'price' => $price,
                        'config_json' => $subKit,
                        'configuration' => array_map(function ($configDetail) use ($subKitConfigItems) {
                            return [
                                'item_id' => $configDetail['item_id'],
                                'name' => $subKitConfigItems[$configDetail['item_id']]['name'],
                                'quantity' => $configDetail['qty'],
                            ];
                        }, Hash::extract($subKit['config'], '{n}.{n}')),
                        'selected' => true,
                    ]);

                    if (Configure::read('ProductBackend.showCost')) {
                        $formattedSubKit['cost'] = $cost;
                    }

                    if (Configure::read('ProductBackend.showStock') && isset($subKitLine['sage_itemcode'])) {
                        $formattedSubKit['sage_itemcode'] = $subKitLine['sage_itemcode'];
                    }

                    return $formattedSubKit;
                }, $subKitItems);
            }

            $this['price'] = $price;
            $this['config_name'] = $configJson['name'];
            $this['config_json'] = $configJson;

            $selectedNonSubKitItems = [];
            foreach ($selectedItems as $selectedItem) {
                if (!isset($selectedItem['subkit'])) {
                    $selectedNonSubKitItems[$selectedItem['item_id']] = $selectedItem['qty'];
                }
            }

            if (Configure::read('ProductBackend.showCost')) {
                $this['cost'] = $cost;
                $this['margin'] = ($price - $cost) / $price;
            }
        }

        // use base configuration
        if (!isset($selectedNonSubKitItems)) {
            $selectedNonSubKitItems = Hash::combine($this['system_items'], '{n}.item_id', '{n}.quantity');
        }

        $subKits = (new Collection($subKits ?? []))->groupBy('id')->toArray();

        $this['buckets'] = array_map(function ($bucket) {
            $bucket['groups'] = array_map(function ($group) {
                $index = 0;
                foreach ($group['group_items'] as $groupItem) {
                    // insert selected sub-kits in each group
                    if ($selectedSubKits = $subKits[$groupItem['id']] ?? []) {
                        array_splice($group['group_items'], $index, 0, $selectedSubKits);
                        $index += count($selectedSubKits);
                    }
                    $index++;
                }

                // select items
                foreach ($group['group_items'] as &$groupItem) {
                    if ($quantity = $selectedNonSubKitItems[$groupItem['id']] ?? null) {
                        $groupItem['quantity'] = $quantity;
                        $groupItem['selected'] = true;
                    }
                }

                return $group;
            }, $bucket['groups']);

            return $bucket;
        }, $this['buckets']);
    }
}

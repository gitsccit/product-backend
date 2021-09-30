<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Datasource\FactoryLocator;
use Cake\ORM\Entity;
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

    public function loadConfiguration($opportunity = null, $lineNumber = null)
    {
        if ($opportunity) {
            $currentDetailLine = $opportunity['opportunity_details'][$lineNumber - 1];
            $opportunitySystem = $currentDetailLine['opportunity_system'];
            $subKitLines = array_filter($opportunity['opportunity_details'],
                function ($systemDetail) use ($currentDetailLine) {
                    return $systemDetail['parent_line_number'] === $currentDetailLine['line_number'];
                });

            // fill in sub-kits' details
            $subKits = array_map(function ($subKitLine) {
                $subKit = $subKitLine['opportunity_system'];
                $formattedSubKit = [
                    'config_id' => $subKit['id'],
                    'original_id' => $subKit['system_id'],
                    'config_name' => $subKit['config_name'],
                    'price' => $subKit['unit_price'],
                    'quantity' => $subKitLine['quantity'],
                    'config_json' => json_decode($subKit['opportunity_system_data']['data'], true),
                    'line_number' => $subKitLine['line_number'],
                    'configuration' => array_values(array_map(function ($systemDetail) {
                        return [
                            'item_id' => $systemDetail['item_id'],
                            'name' => $systemDetail['name'],
                            'quantity' => $systemDetail['quantity'],
                        ];
                    }, array_filter($subKit['opportunity_system_details'], function ($systemDetail) {
                        return $systemDetail['hidden'] === 'no';
                    }))),
                    'selected' => true,
                ];

                if (Configure::read('ProductBackend.showCost')) {
                    $formattedSubKit['cost'] = $subKit['unit_cost'];
                }

                if (Configure::read('ProductBackend.showStock') && isset($subKitLine['sage_itemcode'])) {
                    $formattedSubKit['sage_itemcode'] = $subKitLine['sage_itemcode'];
                }

                return $formattedSubKit;
            }, $subKitLines);

            $this['price'] = $currentDetailLine['unit_price'];
            $this['config_name'] = $opportunitySystem['config_name'];
            $this['config_json'] = json_decode($opportunitySystem['opportunity_system_data']['data'], true);
            $this['opportunity_id'] = $opportunity['id'];
            $this['config_id'] = $opportunitySystem['id'];
            $this['quantity'] = $currentDetailLine['quantity'];

            $selectedItems = [];
            foreach ($opportunitySystem['opportunity_system_details'] as $systemDetail) {
                if ($systemDetail['item_id'] !== null && $systemDetail['line_type'] !== 'subkit') {
                    $selectedItems[$systemDetail['item_id']] = $systemDetail['quantity'];
                }
            }

            if (Configure::read('ProductBackend.showCost')) {
                $this['cost'] = $opportunitySystem['unit_cost'];
                $this['margin'] = ($this['price'] - $this['cost']) / $this['price'];
            }
        }

        // use base configuration
        if (!isset($selectedItems)) {
            $selectedItems = Hash::combine($this['system_items'], '{n}.item_id', '{n}.quantity');
        }

        $subKits = (new Collection($subKits ?? []))->groupBy('original_id')->toArray();

        foreach ($this['buckets'] as &$bucket) {
            foreach ($bucket['groups'] as &$group) {
                $index = 0;
                foreach ($group['group_items'] as &$groupItem) {
                    // insert selected sub-kits in each group
                    if ($selectedSystems = $subKits[$groupItem['original_id']] ?? []) {
                        foreach ($selectedSystems as &$selectedSystem) {
                            $selectedSystem = array_merge($groupItem, $selectedSystem);
                        }
                        array_splice($group['group_items'], $index, 0, $selectedSystems);
                        $index += count($selectedSystems);
                    }
                    $index++;

                    // select items
                    if ($quantity = $selectedItems[$groupItem['id']] ?? null) {
                        $groupItem['quantity'] = $quantity;
                        $groupItem['selected'] = true;
                    }
                }
            }
        }
    }
}

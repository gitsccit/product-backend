<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Collection\CollectionInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Http\Session;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Kits Model
 *
 * @property \ProductBackend\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \ProductBackend\Model\Table\ShipBoxesTable&\Cake\ORM\Association\BelongsTo $ShipBoxes
 * @property \ProductBackend\Model\Table\KitBucketsTable&\Cake\ORM\Association\HasMany $KitBuckets
 * @property \ProductBackend\Model\Table\KitItemsTable&\Cake\ORM\Association\HasMany $KitItems
 * @property \ProductBackend\Model\Table\KitRulesTable&\Cake\ORM\Association\HasMany $KitRules
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\HasMany $Systems
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\BelongsToMany $Buckets
 * @property \ProductBackend\Model\Table\IconsTable&\Cake\ORM\Association\BelongsToMany $Icons
 * @property \ProductBackend\Model\Table\PluginsTable&\Cake\ORM\Association\BelongsToMany $Plugins
 * @property \ProductBackend\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @method \ProductBackend\Model\Entity\Kit newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Kit newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Kit[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Kit get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Kit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Kit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Kit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Kit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Kit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class KitsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('kits');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Locations', [
            'foreignKey' => 'ship_from_id',
            'className' => 'ProductBackend.Locations',
        ]);
        $this->belongsTo('ShipBoxes', [
            'foreignKey' => 'ship_box_id',
            'className' => 'ProductBackend.ShipBoxes',
        ]);
        $this->hasMany('KitBuckets', [
            'foreignKey' => 'kit_id',
            'className' => 'ProductBackend.KitBuckets',
        ]);
        $this->hasMany('KitItems', [
            'foreignKey' => 'kit_id',
            'className' => 'ProductBackend.KitItems',
        ]);
        $this->hasMany('KitRules', [
            'foreignKey' => 'kit_id',
            'className' => 'ProductBackend.KitRules',
        ]);
        $this->hasMany('Systems', [
            'foreignKey' => 'kit_id',
            'className' => 'ProductBackend.Systems',
        ]);
        $this->belongsToMany('Buckets', [
            'foreignKey' => 'kit_id',
            'targetForeignKey' => 'bucket_id',
            'joinTable' => 'kit_buckets',
            'className' => 'ProductBackend.Buckets',
        ]);
        $this->belongsToMany('Icons', [
            'foreignKey' => 'kit_id',
            'targetForeignKey' => 'icon_id',
            'joinTable' => 'icons_kits',
            'className' => 'ProductBackend.Icons',
        ]);
        $this->belongsToMany('Plugins', [
            'foreignKey' => 'kit_id',
            'targetForeignKey' => 'plugin_id',
            'joinTable' => 'kits_plugins',
            'className' => 'ProductBackend.Plugins',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'kit_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'kits_tags',
            'className' => 'ProductBackend.Tags',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->notEmptyString('build_time');

        $validator
            ->scalar('sage_itemcode')
            ->maxLength('sage_itemcode', 30)
            ->notEmptyString('sage_itemcode');

        $validator
            ->scalar('product_rules')
            ->notEmptyString('product_rules');

        $validator
            ->scalar('sku_rules')
            ->notEmptyString('sku_rules');

        $validator
            ->scalar('noise_level')
            ->notEmptyString('noise_level');

        $validator
            ->scalar('power_estimate')
            ->notEmptyString('power_estimate');

        $validator
            ->scalar('pallet_ship')
            ->notEmptyString('pallet_ship');

        $validator
            ->scalar('spares_kit')
            ->allowEmptyString('spares_kit');

        $validator
            ->numeric('length')
            ->greaterThanOrEqual('length', 0)
            ->allowEmptyString('length');

        $validator
            ->numeric('width')
            ->greaterThanOrEqual('width', 0)
            ->allowEmptyString('width');

        $validator
            ->numeric('height')
            ->greaterThanOrEqual('height', 0)
            ->allowEmptyString('height');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

        $validator
            ->dateTime('date_added')
            ->notEmptyDateTime('date_added');

        $validator
            ->dateTime('timestamp')
            ->notEmptyDateTime('timestamp');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['ship_from_id'], 'Locations'), ['errorField' => 'ship_from_id']);
        $rules->add($rules->existsIn(['ship_box_id'], 'ShipBoxes'), ['errorField' => 'ship_box_id']);

        return $rules;
    }

    public function findTags(Query $query, array $options)
    {
        return $query
            ->select([
                'Kits.id',
                'Tags.id',
                'name' => 'Tags.name',
                'image_id' => 'Tags.image_id',
                'value' => "IF(TagCategories.support_text = 'yes', KitsTags.value, '')",
            ])
            ->matching('Tags', function ($q) {
                return $q->innerJoinWith('TagCategories', function ($q) {
                    return $q->where([
                        'TagCategories.support' => 'yes',
                    ]);
                });
            })
            ->group('Tags.id')
            ->order([
                'TagCategories.support_sequence',
                'TagCategories.name',
                'Tags.sort',
                'Tags.name',
            ]);
    }

    public function findFilter(Query $query, array $options)
    {
        $kits = $options['kits'];

        return $query
            ->select([
                'category_id' => 'TagCategories.id',
                'category_name' => 'TagCategories.name',
                'id' => 'Tags.id',
                'name' => 'Tags.name',
                'count' => 'COUNT(DISTINCT Kits.id)',
            ])
            ->innerJoinWith('Tags.TagCategories')
            ->whereInList('Kits.id', $kits)
            ->where([
                'TagCategories.filter' => 'yes',
            ])
            ->group('Tags.id')
            ->order([
                'TagCategories.filter_sequence',
                'TagCategories.name',
                'Tags.sort',
                'Tags.name',
            ])
            ->formatResults(function (CollectionInterface $results) {
                return $results->groupBy('category_id')
                    ->map(function ($tagCategories) {
                        return [
                            'id' => $tagCategories[0]->category_id,
                            'name' => $tagCategories[0]->category_name,
                            'options' => array_map(function ($tagCategory) {
                                return $tagCategory->toArray();
                            }, $tagCategories),
                        ];
                    });
            });
    }

    public function validateBucketItems(int $kitID, array $configuration)
    {
        $errors = [];
        $buckets = $this->Buckets->find('configuration', ['kitID' => $kitID]);

        foreach ($buckets as $bucket) {
            $selectedBucketItemIDs = Hash::extract($configuration[$bucket['id']] ?? [], '{n).item_id');
            $bucketItemsIDs = Hash::extract($bucket, 'groups.{n}.group_items.{n}.id');
            $notFoundItemIDs = array_diff($selectedBucketItemIDs, $bucketItemsIDs);

            if (!empty($notFoundItemIDs)) {
                $notFoundItems = $this->KitItems->GroupItems->find('configuration')->whereInList(
                    'GroupItems.id',
                    $notFoundItemIDs
                );

                foreach ($notFoundItems as $notFoundItem) {
                    $errors[$bucket['id']][] = "$notFoundItem[name] is not found in $bucket[name].";
                }
            }

            $bucketHasItems = array_key_exists($bucket['id'], $configuration);
            $selectedQuantities = Hash::extract($configuration[$bucket['id']] ?? [], '{n}.qty');
            $bucketQuantity = array_sum($selectedQuantities);

            if (!$bucket['multiple'] && !$bucketHasItems) {
                $errors[] = [$bucket['id'], "$bucket[name] requires a selected item."];
            }

            if (!empty($bucket['minqty']) && $bucket['minqty'] > $bucketQuantity) {
                $errors[] = [
                    $bucket['id'],
                    "$bucket[name] minimum quantity $bucket[minqty]." . ($bucketHasItems ? " ($bucketQuantity selected)" : ''),
                ];
            }

            if (!empty($bucket['maxqty']) && $bucket['maxqty'] < $bucketQuantity) {
                $errors[] = [
                    $bucket['id'],
                    "$bucket[name] maximum quantity $bucket[maxqty]." . ($bucketHasItems ? " ($bucketQuantity selected)" : ''),
                ];
            }

            $notFoundQuantities = array_diff($selectedQuantities, $bucket['quantity']);

            foreach ($notFoundQuantities as $quantity) {
                $errors[] = [$bucket['id'], "$quantity is not an available item quantity."];
            }
        }

        return $errors;
    }

    public function validateKitRules(int $kitID, array $configuration)
    {
        $errors = $warnings = [];
        $selectedItemsQuantities = Hash::combine($configuration, '{n}.{n}.item_id', '{n}.{n}.qty');

        $rules = $this->KitRules->find()
            ->contain('KitRuleDetails', function (Query $q) {
                return $q->order('KitRuleDetails.sort');
            })
            ->where(['KitRules.kit_id' => $kitID]);

        foreach ($rules as $rule) {
            $expression = [];

            foreach ($rule->kit_rule_details as $detail) {
                $relation = $detail['relation'] === '=' ? '===' : $detail['relation'];

                switch ($detail['logic']) {
                    case 'AND':
                        $expression[] = '&&';
                        break;
                    case 'OR':
                        $expression[] = '||';
                        break;
                    case '(':
                    case ')':
                        $expression[] = $detail['logic'];
                        break;
                    case 'BUCKET_SELECTED':
                        $bucketSelected = array_key_exists($detail['bucket_id'], $configuration);
                        $negated = $relation === '!=';
                        $expression[] = $bucketSelected === !$negated ? 'true' : 'false';
                        break;
                    case 'BUCKET_QUANTITY':
                        $bucketSelected = array_key_exists($detail['bucket_id'], $configuration);
                        $quantity = $bucketSelected ? array_sum(Hash::extract($configuration[$detail['bucket_id']], '{n}.qty')) : 0;
                        $expression[] = eval("return $quantity $relation $detail[value];") ? 'true' : 'false';
                        break;
                    case 'PRODUCT_SELECTED':
                        $itemSelected = array_key_exists($detail['group_item_id'], $selectedItemsQuantities);
                        $negated = $relation === '!=';
                        $expression[] = $itemSelected === !$negated ? 'true' : 'false';
                        break;
                    case 'PRODUCT_QUANTITY':
                        $itemSelected = array_key_exists($detail['group_item_id'], $selectedItemsQuantities);
                        $quantity = $itemSelected ? $selectedItemsQuantities[$detail['group_item_id']] : 0;
                        $expression[] = eval("return $quantity $relation $detail[value];") ? 'true' : 'false';
                        break;
                }
            }

            $expression = 'return ' . implode(' ', $expression) . ';';
            if (eval($expression)) {
                if ($rule['action'] === 'ERROR') {
                    $errors[] = $rule['description'];
                    continue;
                }

                $warnings[] = $rule['description'];
            }
        }

        return [$warnings, $errors];
    }

    public function validateProductRules(int $kitID, array $configuration)
    {
        $errors = $warnings = [];
        $selectedItemsQuantities = Hash::combine($configuration, '{n}.{n}.item_id', '{n}.{n}.qty');
        $selectedItemIDs = array_keys($selectedItemsQuantities);

        $selectedItemProductIDMap = $this->KitItems->GroupItems->Products
            ->find()
            ->select(['id', 'item_id' => 'GroupItems.id'])
            ->innerJoinWith('GroupItems')
            ->whereInList('GroupItems.id', $selectedItemIDs)
            ->all()
            ->combine('item_id', 'id')
            ->toArray();

        $selectedProductQuantities = [];
        foreach ($selectedItemProductIDMap as $selectedItemID => $selectedProductID) {
            $selectedProductQuantities[$selectedProductID] = $selectedItemsQuantities[$selectedItemID];
        }
        $selectedProductIDs = array_keys($selectedProductQuantities);

        $productIDsInKit = $this->KitItems->GroupItems
            ->find('activeInKit', ['kitID' => $kitID])
            ->innerJoinWith('Groups.Buckets.Kits')
            ->where(['Kits.id' => $kitID])
            ->all()
            ->extract('product_id')
            ->toArray();

        $rules = FactoryLocator::get('Table')->get('ProductBackend.ProductRules')
            ->find()
            ->contain('Products')
            ->formatResults(function (CollectionInterface $results) {
                return $results->map(function ($productRule) {
                    $productRule->products = Hash::extract($productRule->products, '{n}.id');

                    return $productRule;
                });
            });

        foreach ($rules as $rule) {
            $relation = $rule['relation'] === '=' ? '==' : $rule['relation'];
            $conditionRelation = $rule['condition_relation'] === '=' ? '==' : $rule['condition_relation'];
            $quantity = $selectedProductQuantities[$rule['product_id']] ?? 0;

            if ($rule['logic'] !== 'SELECTED') {
                $active = !empty($relation) && eval("return $quantity $relation $rule[quantity];");
            } else {
                $active = $quantity > 0;
            }

            if ($active) {
                $trigger = false;

                switch ($rule['condition']) {
                    case 'OR': // TRUE if none of the following products are selected
                        $trigger = array_intersect($rule['products'], $selectedProductIDs) === 0;
                        break;
                    case 'AND': // TRUE if any one of the following products exists in the kit and is NOT selected
                        $set = array_intersect($rule['products'], $productIDsInKit);
                        $trigger = count(array_intersect($set, $selectedProductIDs)) !== count($set);
                        break;
                    case 'QTY': // evaluate total qty of selected products
                        $quantity = 0;
                        foreach ($rule['products'] as $productID) {
                            $quantity += (float)($selectedProductQuantities[$productID] ?? 0);
                        }
                        $trigger = eval("return $quantity $conditionRelation $rule[condition_quantity];");
                        break;
                }

                if ($trigger) {
                    if ($rule['action'] === 'ERROR') {
                        $errors[] = $rule['description'];
                        continue;
                    }

                    $warnings[] = $rule['description'];
                }
            }
        }

        return [$warnings, $errors];
    }

    public function validateGlobalSpecRules(int $kitID, array $configuration)
    {
        $errors = $warnings = [];
        $productCategories = [];
        $nodes = 1;

        $selectedItemsQuantities = Hash::combine($configuration, '{n}.{n}.item_id', '{n}.{n}.qty');
        $selectedItemIDs = array_keys($selectedItemsQuantities);
        $selectedProducts = $this->KitItems->GroupItems->Products
            ->find()
            ->innerJoinWith('ProductCategories')
            ->innerJoinWith('GroupItems')
            ->whereInList('GroupItems.product_id', $selectedItemIDs)
            ->toArray();

        $specsTable = $this->KitItems->GroupItems->Products->Specifications;
        if ($products = $productCategories['Barebones'] ?? []) {
        } elseif ($products = $productCategories['Chassis'] ?? []) {
        }

        if ($quantity = $productCategories['Video Cards'] ?? 0) { // video card
            switch ($quantity) {
                case 2:
                    $specificationFieldID = 1996; // 2-way sli/crossfile
                    break;
                case 3:
                    $specificationFieldID = 1997; // 3-way sli/crossfile
                    break;
                case 4:
                    $specificationFieldID = 2054; // 4-way sli/crossfile
                    break;
                default:
                    $specificationFieldID = 1975;
                    break;
            }

            $minPower = $specsTable->find()->select(['sort'])->where([
                'specification_field_id' => $specificationFieldID,
//                'product_id' => $productCategories[],
            ])->all()->extract('sort')->first();

            if ($minPower) {
                $powerMap = [
                    'Chassis' => 1098,
                    'Power Supply' => 594,
                    'Barebones' => 638,
                ];

//                $specsTable->find()->where([
//                    '' => '',
//                ]);
            }
        }

        return [$warnings, $errors];
    }

    public function validateSkuRules(array $configuration, $options = [])
    {
        $additionalItems = [];
        $cost = 0.0;
        $price = 0.0;
        $selectedItemsQuantities = Hash::combine($configuration, '{n}.{n}.item_id', '{n}.{n}.qty');
        $selectedItemIDs = array_keys($selectedItemsQuantities);

        $sageItemCodes = [];
        $selectedProducts = $this->KitItems->GroupItems
            ->find()
            ->select([
                'GroupItems.id',
                'sage_itemcode' => 'Products.sage_itemcode',
            ])
            ->innerJoinWith('Products')
            ->whereInList('GroupItems.id', $selectedItemIDs)
            ->where([
                'LENGTH(Products.sage_itemcode) >' => 0,
                'Products.sage_itemcode <>' => 'Need Sku',
            ]);

        foreach ($selectedProducts as $selectedProduct) {
            $sageItemCodes[$selectedProduct['id']] = $selectedProduct['sage_itemcode'];
        }

        $sageItemCodePlaceholders = implode(',', array_fill(0, count($sageItemCodes), '?'));
        $rules = $this->getConnection()->execute("SELECT sr.*
FROM sku_rule_group_skus srgs
INNER JOIN sku_rule_groups srg ON srg.id = srgs.sku_rule_group_id
INNER JOIN sku_rules sr ON sr.id = srg.sku_rule_id
LEFT JOIN sku_rule_groups srg2 ON srg2.sku_rule_id = sr.id
WHERE sr.active = 'yes'
AND srgs.sage_itemcode IN ($sageItemCodePlaceholders)
GROUP BY sr.id
HAVING GROUP_CONCAT(DISTINCT srg.id ORDER BY srg.id) = GROUP_CONCAT(DISTINCT srg2.id ORDER BY srg2.id)
ORDER BY sr.sort", array_values($sageItemCodes))->fetchAll('assoc');

        foreach ($rules as $rule) {
            // count kit items per-group
            $columns = [];
            $stm = $this->getConnection()->execute("SELECT DISTINCT srgs.sage_itemcode,srg.id
FROM sku_rule_group_skus srgs
INNER JOIN sku_rule_groups srg ON srg.id = srgs.sku_rule_group_id
INNER JOIN sku_rules sr ON sr.id = srg.sku_rule_id
WHERE sr.id = ?
AND sr.active = 'yes'
AND srgs.sage_itemcode IN ($sageItemCodePlaceholders)", array_merge([$rule['id']], array_values($sageItemCodes)))
                ->fetchAll();

            foreach ($stm as $l) {
                if (!isset($columns[$l[1]])) {
                    $columns[$l[1]] = 0;
                }
                foreach ($sageItemCodes as $itemID => $sageItemCode) {
                    if ($sageItemCode == $l[0] && isset($selectedItemsQuantities[$itemID])) {
                        $columns[$l[1]] += $selectedItemsQuantities[$itemID];
                    }
                }
            }

            // Is this rule filtered by quantity?
            if (!empty($line['sku_rule_group_id']) && !empty($line['eval_logic']) && !empty($line['eval_quantity'])) {
                $quantity = empty($columns[$line['sku_rule_group_id']]) ? 0 : $columns[$line['sku_rule_group_id']];
                $relation = $line['eval_logic'] === '=' ? '==' : $line['eval_logic'];
                if (eval("return $quantity $relation $line[eval_quantity];") === false) {
                    continue;
                }
            } // do not apply this rule

            $session = new Session();
            $perspectiveID = $options['perspective'] ?? $session->read('store.perspective');
            $priceLevelID = $options['priceLevel'] ?? $session->read('store.price-level');
            $stm = $this->getConnection()->execute("SELECT sras.*,IFNULL(pp.name,p.name) AS name,p.cost,ppl.price
FROM sku_rule_additional_skus sras
INNER JOIN products p ON p.sage_itemcode = sras.sage_itemcode
INNER JOIN product_price_levels ppl ON ppl.product_id = p.id AND ppl.price_level_id = ?
LEFT JOIN product_perspectives pp ON pp.product_id = p.id AND pp.perspective_id = ?
WHERE sras.sku_rule_id = ?
AND sras.sell_price = 'yes'
GROUP BY sras.id", [$priceLevelID, $perspectiveID, $rule['id']])->fetchAll('assoc');
            foreach ($stm as $l) {
                $quantity = (float)$l['quantity'] * (float)$columns[$l['sku_rule_group_id']];
                $quantity += (float)$l['quantity_modifier'];
                if ($quantity > 0) {
                    $additionalItems[] = ($quantity > 1 ? $quantity . ' x ' : '') . "$l[name] [+" . number_format(
                        $l['price'] * $quantity,
                        2,
                        '.',
                        ','
                    ) . ']';
                    $price += $l['price'] * $quantity;
                    $cost += $l['cost'] * $quantity;
                }
            }
        }

        return [$cost, $price, $additionalItems];
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName(): string
    {
        return 'product_backend';
    }
}

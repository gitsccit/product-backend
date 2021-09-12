<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Collection\CollectionInterface;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GroupItems Model
 *
 * @property \ProductBackend\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\BelongsTo $Systems
 * @property \ProductBackend\Model\Table\KitItemsTable&\Cake\ORM\Association\HasMany $KitItems
 * @property \ProductBackend\Model\Table\KitRuleDetailsTable&\Cake\ORM\Association\HasMany $KitRuleDetails
 * @property \ProductBackend\Model\Table\SystemItemsTable&\Cake\ORM\Association\HasMany $SystemItems
 * @method \ProductBackend\Model\Entity\GroupItem newEmptyEntity()
 * @method \ProductBackend\Model\Entity\GroupItem newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\GroupItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class GroupItemsTable extends Table
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

        $this->setTable('group_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Groups',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.Products',
        ]);
        $this->belongsTo('Systems', [
            'foreignKey' => 'system_id',
            'className' => 'ProductBackend.Systems',
        ]);
        $this->hasMany('KitItems', [
            'foreignKey' => 'group_item_id',
            'className' => 'ProductBackend.KitItems',
        ]);
        $this->hasMany('KitRuleDetails', [
            'foreignKey' => 'group_item_id',
            'className' => 'ProductBackend.KitRuleDetails',
        ]);
        $this->hasMany('SystemItems', [
            'foreignKey' => 'item_id',
            'className' => 'ProductBackend.SystemItems',
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
        $rules->add($rules->existsIn(['group_id'], 'Groups'), ['errorField' => 'group_id']);
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn(['system_id'], 'Systems'), ['errorField' => 'system_id']);

        return $rules;
    }

    public function findConfiguration(Query $query, array $options = [])
    {
        return $query
            ->formatResults(function (CollectionInterface $result) use ($options) {
                $products = $systems = [];

                if ($productIDs = $result->extract('product_id')->toList()) {
                    $products = $this->Products
                        ->find('basic', $options)
                        ->find('image')
                        ->contain('Specifications', function (Query $q) {
                            return $q->find('specifications');
                        })
                        ->whereInList('Products.id', $productIDs)
                        ->indexBy('id')
                        ->toArray();
                }

                if ($systemIDs = $result->extract('system_id')->toList()) {
                    $systems = $this->Systems
                        ->find('active', $options)
                        ->find('image')
                        ->whereInList('Systems.id', $systemIDs)
                        ->indexBy('id')
                        ->toArray();

                    $configuration = $this->Systems->SystemItems->find()
                        ->innerJoinWith('GroupItems.Products', function (Query $q) use ($options) {
                            return $q->find('basic', $options);
                        })
                        ->whereInList('SystemItems.system_id', $systemIDs)
                        ->indexBy('system_id')
                        ->toArray();

                    foreach ($systems as &$system) {
                        $system['configuration'] = $configuration[$system['id']];
                    }
                }

                return $result
                    ->filter(function ($groupItem) use ($products, $systems) {
                        return isset($products[$groupItem['product_id']]) || isset($systems[$groupItem['system_id']]);
                    })
                    ->map(function ($groupItem) use ($products, $systems, $options) {
                        $item = $products[$groupItem['product_id']] ?? $systems[$groupItem['system_id']];
                        $unifiedItem['id'] = $groupItem['id'];
                        $unifiedItem['original_id'] = $item['id'];
                        $unifiedItem['group_id'] = $groupItem['group_id'];
                        $unifiedItem['type'] = $groupItem['product_id'] ? 'product' : 'system';
                        $unifiedItem['name'] = $item['name'];
                        $unifiedItem['url'] = $item['url'];
                        $unifiedItem['image_id'] = $item['image_id'];
                        $unifiedItem['status'] = $item['status'];
                        $unifiedItem['status_text'] = $item['status_text'];
                        $unifiedItem['warning'] = $item['warning'];
                        $unifiedItem['price'] = $item['price'];
                        $unifiedItem['specs'] = $item['specifications'];
                        $unifiedItem['selected'] = false;

                        if ($quantity = $options['selectedItems'][$unifiedItem['id']]) {
                            $unifiedItem['quantity'] = $quantity;
                            $unifiedItem['selected'] = true;
                        }

                        if ($groupItem['system_id']) {
                            $unifiedItem['configuration'] = $item['configuration'];
                        }

                        if (Configure::read('ProductBackend.showCost')) {
                            $unifiedItem['cost'] = $item['cost'];
                        }

                        if (Configure::read('ProductBackend.showStock') && isset($item['sage_itemcode'])) {
                            $unifiedItem['sage_itemcode'] = $item['sage_itemcode'];
                        }

                        return $unifiedItem;
                    });
            });
    }

    public function findActiveInKit(Query $query, array $options = [])
    {
        $kitID = $options['kitID'];

        return $query
            ->leftJoinWith('KitItems', function (Query $q) use ($kitID) {
                return $q->where([
                    'KitItems.kit_id' => $kitID,
                ]);
            })
            ->where([
                "IFNULL(KitItems.active, 'yes') = 'yes'",
            ]);
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

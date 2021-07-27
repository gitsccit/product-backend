<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Session;
use Cake\I18n\Number;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Systems Model
 *
 * @property \ProductBackend\Model\Table\KitsTable&\Cake\ORM\Association\BelongsTo $Kits
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\BelongsTo $SystemCategories
 * @property \ProductBackend\Model\Table\GroupItemsTable&\Cake\ORM\Association\HasMany $GroupItems
 * @property \ProductBackend\Model\Table\SystemItemsTable&\Cake\ORM\Association\HasMany $SystemItems
 * @property \ProductBackend\Model\Table\SystemPerspectivesTable&\Cake\ORM\Association\HasMany $SystemPerspectives
 * @property \ProductBackend\Model\Table\SystemPriceLevelsTable&\Cake\ORM\Association\HasMany $SystemPriceLevels
 * @method \ProductBackend\Model\Entity\System newEmptyEntity()
 * @method \ProductBackend\Model\Entity\System newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\System[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\System get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\System findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\System patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\System[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\System|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\System saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\System[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemsTable extends Table
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

        $this->setTable('systems');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Kits', [
            'foreignKey' => 'kit_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Kits',
        ]);
        $this->belongsTo('SystemCategories', [
            'foreignKey' => 'system_category_id',
            'className' => 'ProductBackend.SystemCategories',
        ]);
        $this->hasMany('GroupItems', [
            'foreignKey' => 'system_id',
            'className' => 'ProductBackend.GroupItems',
        ]);
        $this->hasMany('SystemItems', [
            'foreignKey' => 'system_id',
            'className' => 'ProductBackend.SystemItems',
        ]);
        $this->hasMany('SystemPerspectives', [
            'foreignKey' => 'system_id',
            'className' => 'ProductBackend.SystemPerspectives',
        ]);
        $this->hasMany('SystemPriceLevels', [
            'foreignKey' => 'system_id',
            'className' => 'ProductBackend.SystemPriceLevels',
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
            ->scalar('configurable')
            ->notEmptyString('configurable');

        $validator
            ->numeric('cost')
            ->allowEmptyString('cost');

        $validator
            ->scalar('price_lock')
            ->notEmptyString('price_lock');

        $validator
            ->scalar('url')
            ->maxLength('url', 80)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('name_line_1')
            ->maxLength('name_line_1', 30)
            ->requirePresence('name_line_1', 'create')
            ->notEmptyString('name_line_1');

        $validator
            ->scalar('name_line_2')
            ->maxLength('name_line_2', 50)
            ->requirePresence('name_line_2', 'create')
            ->notEmptyString('name_line_2');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('meta_title')
            ->maxLength('meta_title', 90)
            ->allowEmptyString('meta_title');

        $validator
            ->scalar('meta_keywords')
            ->allowEmptyString('meta_keywords');

        $validator
            ->scalar('meta_description')
            ->allowEmptyString('meta_description');

        $validator
            ->nonNegativeInteger('force_perspective')
            ->allowEmptyString('force_perspective');

        $validator
            ->scalar('category_browse')
            ->notEmptyString('category_browse');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

        $validator
            ->nonNegativeInteger('sort')
            ->notEmptyString('sort');

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
        $rules->add($rules->existsIn(['kit_id'], 'Kits'), ['errorField' => 'kit_id']);
        $rules->add(
            $rules->existsIn(['system_category_id'], 'SystemCategories'),
            ['errorField' => 'system_category_id']
        );

        return $rules;
    }

    public function findPrice(Query $query, array $options)
    {
        $session = new Session();
        $priceLevelId = $options['priceLevel'] ?? $session->read('options.store.price-level');

        return $query
            ->select([
                'price' => 'SystemPriceLevels.price',
            ])
            ->innerJoinWith('SystemPriceLevels', function (Query $q) use ($priceLevelId) {
                return $q->where(['SystemPriceLevels.price_level_id' => $priceLevelId]);
            });
    }

    public function findBasic(Query $query, array $options)
    {
        $session = new Session();
        $perspectiveId = $options['perspective'] ?? $session->read('options.store.perspective');

        if (Configure::read('ProductBackend.showCost')) {
            $query
                ->contain('SystemItems.GroupItems', function ($query) use ($options) {
                    return $query->find('configuration', $options);
                })
                ->formatResults(function ($result) {
                    return $result->each(function ($system) {
                        $system->cost = 0;
                        foreach ($system->system_items as $systemItem) {
                            $system->cost += $systemItem['group_item']['cost'] * $systemItem['quantity'];
                        }
                        $system->gross_margin = Number::toPercentage(($system->price - $system->cost) / $system->price * 100);
                    });
                });
        }

        return $query
            ->find('price', $options)
            ->select([
                'Systems.id',
                'Systems.kit_id',
                'Systems.system_category_id',
                'url' => 'IFNULL(SystemPerspectives.url, Systems.url)',
                'name' => 'IFNULL(SystemPerspectives.name, Systems.name)',
            ])
            ->leftJoinWith('SystemPerspectives', function (Query $q) use ($perspectiveId) {
                return $q->where(['SystemPerspectives.perspective_id' => $perspectiveId]);
            })
            ->group(['Systems.id'])
            ->order([
                'Systems.sort' => 'ASC',
                'IFNULL(SystemPerspectives.name, Systems.name)' => 'ASC',
            ]);
    }

    public function findActive(Query $query, array $options)
    {
        return $query
            ->find('basic', $options)
            ->where([
                'IFNULL(SystemPerspectives.active, Systems.active) =' => 'yes',
            ]);
    }

    public function findListing(Query $query, array $options)
    {
        return $query
            ->select([
                'name_line_1' => 'IFNULL(SystemPerspectives.name_line_1, Systems.name_line_1)',
                'name_line_2' => 'IFNULL(SystemPerspectives.name_line_2, Systems.name_line_2)',
            ])
            ->find('active', $options)
            ->find('supportBadge', $options)
            ->find('image', ['type' => 'Browse'])
            ->contain([
                'Kits.Tags' => function (Query $query) {
                    return $query
                        ->select([
                            'id' => 'Tags.id',
                            'Tags.name',
                            'Tags.image_id',
                            'value' => "IF(TagCategories.support_text = 'yes', KitsTags.value, '')",
                            'category' => 'TagCategories.name',
                        ])
                        ->innerJoinWith('TagCategories')
                        ->where([
                            'TagCategories.support' => 'yes',
                        ])
                        ->order([
                            'TagCategories.support_sequence',
                            'TagCategories.name',
                            'Tags.sort',
                            'Tags.name',
                        ]);
                },
            ])
            ->select($this->Kits)
            ->formatResults(function ($result) {
                return $result->each(function ($system) {
                    $tags = new Collection($system->kit->tags);
                    $tagCategories = $tags->groupBy('category')->toArray();
                    $system->tags = [];
                    $tagCount = 7;

                    while (count($system->tags) < $tagCount && count($tagCategories) > 0) {
                        foreach ($tagCategories as $tagCategory => $tags) {
                            $system->tags[] = array_shift($tags);
                            $tagCategories[$tagCategory] = $tags;

                            if (empty($tags)) {
                                unset($tagCategories[$tagCategory]);
                            }

                            if (count($system->tags) === $tagCount) {
                                break;
                            }
                        }
                    }

                    unset($system->kit);
                });
            });
    }

    public function findSupportBadge(Query $query, array $options)
    {
        return $query
            ->select([
                'support_badge' => 'Tags.name',
                'support_badge_info' => 'KitsTags.value',
            ])
            ->innerJoinWith('Kits', function (Query $q) {
                return $q->leftJoinWith('Tags');
            })
            ->where(['Tags.tag_category_id' => 18]);
    }

    public function findDetails(Query $query, array $options)
    {
        return $query
            ->find('active', $options)
            ->find('image', ['type' => 'System'])
            ->find('baseConfiguration')
            ->select([
                'description' => 'IFNULL(SystemPerspectives.description, Systems.description)',
                'meta_title' => 'IFNULL(SystemPerspectives.meta_title, Systems.meta_title)',
                'meta_keywords' => 'IFNULL(SystemPerspectives.meta_keywords, Systems.meta_keywords)',
                'meta_description' => 'IFNULL(SystemPerspectives.meta_description, Systems.meta_description)',
                'Systems.force_perspective',
                'build_time' => 'Kits.build_time',
                'noise_level' => 'Kits.noise_level',
                'power_estimate' => 'Kits.power_estimate',
            ])
            ->innerJoinWith('Kits')
            ->formatResults(function ($result) use ($options) {
                return $result->map(function ($system) use ($options) {
                    $system->noise_level = $system->noise_level === 'yes';
                    $system->power_estimate = $system->power_estimate === 'yes';
                    $system->buckets = $this->Kits->Buckets->find(
                        'configuration',
                        ['kitID' => $system->kit_id]
                    )->find('filters')->toList();

                    if (Configure::read('ProductBackend.showStock')) {
                        $thinkAPI = Client::createFromUrl(Configure::read('Urls.thinkAPI'));
                        $thinkAPI->setConfig([
                            'headers' => [
                                'scctoken' => Configure::read('Security.thinkAPI_token'),
                            ],
                            'ssl_verify_peer' => false,
                        ]);
                        $session = new Session();
                        $warehouseCode = $options['warehouse'] ?? $session->read('options.store.warehouse');
                        $itemCodes = array_values(array_unique(Hash::extract(
                            $system->buckets,
                            '{n}.groups.{n}.group_items.{n}.sage_itemcode'
                        )));
                        $result = $thinkAPI->post(
                            "/sage100/items/availability.json?warehousecode=$warehouseCode",
                            json_encode($itemCodes)
                        );
                        $itemCodesAvaiability = Hash::combine(
                            $result->getJson()['items'],
                            '{n}.ItemCode',
                            '{n}.Warehouses.{n}.Available'
                        );
                        foreach ($system->buckets as &$bucket) {
                            foreach ($bucket->groups as &$group) {
                                foreach ($group->group_items as &$groupItem) {
                                    if (isset($itemCodesAvaiability[$groupItem['sage_itemcode']])) {
                                        $groupItem['availableQuantity'] = $itemCodesAvaiability[$groupItem['sage_itemcode']];
                                    }
                                    unset($groupItem['sage_itemcode']);
                                }
                            }
                        }
                    }

                    return $system;
                });
            });
    }

    public function getConfigurationCostAndPrice($systemID, $configuration, $options = [])
    {
        $selectedItemsQuantities = Hash::combine($configuration, '{n}.{n}.item_id', '{n}.{n}.qty');

        $selectedItems = $this->GroupItems->find('configuration', $options)->whereInList(
            'GroupItems.id',
            array_keys($selectedItemsQuantities)
        );
        $system = $this->find(
            'price',
            $options
        )->select(['fpa' => 'SystemPriceLevels.fpa'])->where(['Systems.id' => $systemID])->first();
        $price = $selectedItems->reduce(function ($carry, $item) use ($selectedItemsQuantities) {
            return $carry + $item['price'] * $selectedItemsQuantities[$item['id']];
        }, $system['fpa']);
        $cost = $selectedItems->reduce(function ($carry, $item) use ($selectedItemsQuantities) {
            return $carry + $item['cost'] * $selectedItemsQuantities[$item['id']];
        }, 0.0);

        return [$cost, $price];
    }

    public function findBaseConfiguration(Query $query, array $options)
    {
        return $query->contain('SystemItems');
    }

    public function findImage(Query $query, array $options)
    {
        $imageType = $options['type'] ?? 'Browse';

        if (!in_array($imageType, ['Browse', 'System'])) {
            throw new \InvalidArgumentException('Image type must be one of `Browse` or `System`.');
        }

        return $query
            ->select([
                'image_id' => 'file_id',
            ])
            ->leftJoinWith("SystemItems.GroupItems.Products.Galleries.${imageType}GalleryImages")
            ->leftJoinWith('SystemItems.GroupItems.Products.ProductCategories')
            ->where([
                "${imageType}GalleryImages.id IS NOT NULL",
                "${imageType}GalleryImages.active" => 'yes',
            ])
            ->order([
                'ProductCategories.gallery_priority' => 'DESC',
                'Products.cost' => 'DESC',
                'Products.sort',
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

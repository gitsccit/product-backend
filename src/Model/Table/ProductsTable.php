<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Core\Configure;
use Cake\Http\Session;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\BelongsTo $ProductCategories
 * @property \ProductBackend\Model\Table\GalleriesTable&\Cake\ORM\Association\BelongsTo $Galleries
 * @property \ProductBackend\Model\Table\ManufacturersTable&\Cake\ORM\Association\BelongsTo $Manufacturers
 * @property \ProductBackend\Model\Table\ProductStatusesTable&\Cake\ORM\Association\BelongsTo $ProductStatuses
 * @property \ProductBackend\Model\Table\ShipBoxesTable&\Cake\ORM\Association\BelongsTo $ShipBoxes
 * @property \ProductBackend\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \ProductBackend\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \ProductBackend\Model\Table\CustomerProductsTable&\Cake\ORM\Association\HasMany $CustomerProducts
 * @property \ProductBackend\Model\Table\GenericsTable&\Cake\ORM\Association\HasMany $Generics
 * @property \ProductBackend\Model\Table\GroupItemsTable&\Cake\ORM\Association\HasMany $GroupItems
 * @property \ProductBackend\Model\Table\ProductAdditionalSkusTable&\Cake\ORM\Association\HasMany $ProductAdditionalSkus
 * @property \ProductBackend\Model\Table\ProductPerspectivesTable&\Cake\ORM\Association\HasMany $ProductPerspectives
 * @property \ProductBackend\Model\Table\ProductPriceLevelsTable&\Cake\ORM\Association\HasMany $ProductPriceLevels
 * @property \ProductBackend\Model\Table\ProductRulesTable&\Cake\ORM\Association\HasMany $ProductRules
 * @property \ProductBackend\Model\Table\SparesTable&\Cake\ORM\Association\HasMany $Spares
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\HasMany $Specifications
 * @property \ProductBackend\Model\Table\GenericsTable&\Cake\ORM\Association\BelongsToMany $Generics
 * @property \ProductBackend\Model\Table\ProductRulesTable&\Cake\ORM\Association\BelongsToMany $ProductRules
 * @property \ProductBackend\Model\Table\ProductsRelationsTable&\Cake\ORM\Association\BelongsToMany $RelatedProducts
 *
 * @method \ProductBackend\Model\Entity\Product newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Product get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Product findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Product[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductsTable extends Table
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

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'ProductBackend.ProductCategories',
        ]);
        $this->belongsTo('Galleries', [
            'foreignKey' => 'gallery_id',
            'className' => 'ProductBackend.Galleries',
        ]);
        $this->belongsTo('Manufacturers', [
            'foreignKey' => 'manufacturer_id',
            'className' => 'ProductBackend.Manufacturers',
        ]);
        $this->belongsTo('ProductStatuses', [
            'foreignKey' => 'status_id',
            'className' => 'ProductBackend.ProductStatuses',
        ]);
        $this->belongsTo('ShipBoxes', [
            'foreignKey' => 'ship_box_id',
            'className' => 'ProductBackend.ShipBoxes',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'country_of_origin_id',
            'className' => 'ProductBackend.Locations',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'ship_from_id',
            'className' => 'ProductBackend.Locations',
        ]);
        $this->hasMany('CustomerProducts', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.CustomerProducts',
        ]);
        $this->hasMany('Generics', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.Generics',
        ]);
        $this->hasMany('GroupItems', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.GroupItems',
        ]);
        $this->hasMany('ProductAdditionalSkus', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.ProductAdditionalSkus',
        ]);
        $this->hasMany('ProductPerspectives', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.ProductPerspectives',
        ]);
        $this->hasMany('ProductPriceLevels', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.ProductPriceLevels',
        ]);
        $this->hasMany('ProductRules', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.ProductRules',
        ]);
        $this->hasMany('Spares', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.Spares',
        ]);
        $this->hasMany('Specifications', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsToMany('Generics', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'generic_id',
            'joinTable' => 'generics_products',
            'className' => 'ProductBackend.Generics',
        ]);
        $this->belongsToMany('ProductRules', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'product_rule_id',
            'joinTable' => 'product_rules_products',
            'className' => 'ProductBackend.ProductRules',
        ]);
        $this->belongsToMany('RelatedProducts', [
            'className' => 'Products',
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'related_id',
            'joinTable' => 'products_relations',
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
            ->scalar('url')
            ->maxLength('url', 80)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->scalar('name')
            ->maxLength('name', 120)
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('part_number')
            ->maxLength('part_number', 40)
            ->requirePresence('part_number', 'create')
            ->notEmptyString('part_number');

        $validator
            ->scalar('sage_itemcode')
            ->maxLength('sage_itemcode', 30)
            ->allowEmptyString('sage_itemcode');

        $validator
            ->scalar('upc')
            ->maxLength('upc', 14)
            ->allowEmptyString('upc');

        $validator
            ->scalar('status_text')
            ->maxLength('status_text', 130)
            ->allowEmptyString('status_text');

        $validator
            ->scalar('tax')
            ->allowEmptyString('tax');

        $validator
            ->numeric('cost')
            ->notEmptyString('cost');

        $validator
            ->scalar('cost_maintenance')
            ->notEmptyString('cost_maintenance');

        $validator
            ->scalar('generic')
            ->notEmptyString('generic');

        $validator
            ->boolean('noise_level')
            ->allowEmptyString('noise_level');

        $validator
            ->scalar('generic_relations')
            ->notEmptyString('generic_relations');

        $validator
            ->allowEmptyString('kit_price_percent');

        $validator
            ->scalar('show_related_systems')
            ->allowEmptyString('show_related_systems');

        $validator
            ->scalar('ship_type')
            ->notEmptyString('ship_type');

        $validator
            ->numeric('weight')
            ->notEmptyString('weight');

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
            ->scalar('lithium_battery')
            ->notEmptyString('lithium_battery');

        $validator
            ->numeric('watts')
            ->greaterThanOrEqual('watts', 0)
            ->allowEmptyString('watts');

        $validator
            ->notEmptyString('system_use');

        $validator
            ->notEmptyString('system_start');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

        $validator
            ->integer('sort')
            ->notEmptyString('sort');

        $validator
            ->date('date_eol')
            ->allowEmptyDate('date_eol');

        $validator
            ->dateTime('date_added')
            ->allowEmptyDateTime('date_added');

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
        $rules->add($rules->existsIn(['product_category_id'], 'ProductCategories'),
            ['errorField' => 'product_category_id']);
        $rules->add($rules->existsIn(['gallery_id'], 'Galleries'), ['errorField' => 'gallery_id']);
        $rules->add($rules->existsIn(['manufacturer_id'], 'Manufacturers'), ['errorField' => 'manufacturer_id']);
        $rules->add($rules->existsIn(['status_id'], 'ProductStatuses'), ['errorField' => 'status_id']);
        $rules->add($rules->existsIn(['ship_box_id'], 'ShipBoxes'), ['errorField' => 'ship_box_id']);
        $rules->add($rules->existsIn(['country_of_origin_id'], 'Locations'), ['errorField' => 'country_of_origin_id']);
        $rules->add($rules->existsIn(['ship_from_id'], 'Locations'), ['errorField' => 'ship_from_id']);

        return $rules;
    }

    public function findBasic(Query $query, array $options)
    {
        $session = new Session();
        $perspectiveId = $options['perspective'] ?? $session->read('options.store.perspective');
        $priceLevelId = $options['priceLevel'] ?? $session->read('options.store.price-level');

        if (Configure::read('ProductBackend.showCost')) {
            $query->select([
                'Products.cost',
            ]);
        }

        if (Configure::read('ProductBackend.showStock')) {
            $query->select([
                'Products.sage_itemcode',
            ]);
        }

        return $query
            ->select([
                'Products.id',
                'url' => 'IFNULL(ProductPerspectives.url, Products.url)',
                'name' => 'IFNULL(ProductPerspectives.name, Products.name)',
                'price' => 'ProductPriceLevels.price',
                'Products.status_text',
                'ProductStatuses.warning',
                'status' => 'ProductStatuses.name',
                'Products.part_number',
            ])
            ->leftJoinWith('ProductPerspectives', function (Query $q) use ($perspectiveId) {
                return $q->where(['ProductPerspectives.perspective_id' => $perspectiveId]);
            })
            ->leftJoinWith('ProductStatuses')
            ->innerJoinWith('ProductPriceLevels', function (Query $q) use ($priceLevelId) {
                return $q->where([
                    'ProductPriceLevels.price_level_id' => $priceLevelId,
                ]);
            })
            ->group(['Products.id'])
            ->order([
                'Products.sort' => 'ASC',
                'IFNULL(ProductPerspectives.name, Products.name)' => 'ASC',
            ]);
    }

    public function findActive(Query $query, array $options)
    {
        return $query
            ->find('basic')
            ->where([
                'IFNULL(ProductPerspectives.active, Products.active) =' => 'yes',
            ]);
    }

    public function findCompare(Query $query, array $options)
    {
        return $query
            ->find('basic')
            ->find('image')
            ->find('specificationGroups')
            ->select($this->Manufacturers)
            ->contain(['Manufacturers']);
    }

    public function findListing(Query $query, array $options)
    {
        return $query
            ->find('active')
            ->find('image')
            ->select([
                'Products.product_category_id',
                'Products.description',
                'show_related_systems' => "IFNULL(Products.show_related_systems, ProductCategories.show_related_systems) = 'yes'",
                'specs_overview' => $this->Specifications->find()
                    ->select([
                        'description' => "GROUP_CONCAT(Specifications.text_value ORDER BY
                         SpecificationGroups.sort ASC, SpecificationFields.sort ASC, Specifications.sort ASC
                         SEPARATOR ', ')",
                    ])
                    ->innerJoinWith('SpecificationFields.SpecificationGroups')
                    ->where(['Specifications.product_id = Products.id'])
                    ->group('Specifications.product_id')
                    ->limit(10),
                'url' => 'IFNULL(ProductPerspectives.url, Products.url)',
                'name' => 'IFNULL(ProductPerspectives.name, Products.name)',
            ])
            ->select($this->Manufacturers)
            ->contain(['Manufacturers'])
            ->innerJoinWith('ProductCategories');
    }

    public function findDetails(Query $query, array $options)
    {
        return $query
            ->find('listing')
            ->find('relatedSystems')
            ->find('specificationGroups')
            ->select(['Products.gallery_id'])
            ->select($this->Galleries)
            ->contain([
                'Galleries.GalleryImages' => function ($q) {
                    return $q->where(['GalleryImages.active' => 'yes'])->order('GalleryImages.sort');
                },
            ]);
    }

    public function findImage(Query $query, array $options)
    {
        return $query
            ->select([
                'image_id' => 'ProductGalleryImages.file_id',
            ])
            ->leftJoinWith('Galleries.ProductGalleryImages');
    }

    public function findSpecifications(Query $query, array $options)
    {
        $session = new Session();
        $perspectiveId = $session->read('options.store.perspective');
        $productCategoryId = $options['productCategoryId'];

        return $query
            ->select([
                'id' => 'SpecificationFields.id',
                'name' => 'SpecificationFields.name',
                'value' => 'Specifications.text_value',
                'count' => 'COUNT(DISTINCT Specifications.id)',
            ])
            ->leftJoinWith('ProductPerspectives', function (Query $q) use ($perspectiveId) {
                return $q->where(['ProductPerspectives.perspective_id' => $perspectiveId]);
            })
            ->innerJoinWith('Specifications.SpecificationFields.SpecificationGroups')
            ->leftJoinWith('Specifications.SpecificationUnits')
            ->where([
                'Products.product_category_id' => $productCategoryId,
                'IFNULL(ProductPerspectives.active, Products.active) =' => 'yes',
                'SpecificationFields.techspec' => 'yes',
            ])
            ->group(['SpecificationFields.id', 'Specifications.text_value'])
            ->order([
                'SpecificationGroups.sort',
                'SpecificationGroups.name',
                'SpecificationFields.sort',
                'SpecificationGroups.name',
                'Specifications.sequence',
                'Specifications.sort',
                'Specifications.text_value',
            ])
            ->formatResults(function (CollectionInterface $results) {
                return $results->groupBy('id')
                    ->map(function ($specificationSet) {
                        return [
                            'id' => $specificationSet[0]->id,
                            'name' => $specificationSet[0]->name,
                            'options' => array_map(function ($specification) {
                                return [
                                    'id' => $specification['id'],
                                    'name' => $specification['value'],
                                    'count' => $specification['count'],
                                ];
                            }, $specificationSet),
                        ];
                    });
            });
    }

    public function findSpecificationGroups(Query $query, array $options)
    {
        return $query
            ->contain([
                'Specifications' => function ($q) {
                    return $q
                        ->select([
                            'category' => 'SpecificationGroups.name',
                            'name' => 'SpecificationFields.name',
                            'Specifications.text_value',
                            'Specifications.product_id',
                        ])
                        ->innerJoinWith('SpecificationFields.SpecificationGroups')
                        ->where(['SpecificationFields.techspec' => 'yes'])
                        ->order([
                            'SpecificationGroups.sort',
                            'SpecificationFields.sort',
                            'Specifications.sequence',
                        ]);
                },
            ])
            ->formatResults(function ($result) {
                return $result->map(function ($product) {
                    $product->specification_groups = (new Collection($product->specifications))->groupBy('category')->toArray();

                    return $product;
                });
            });
    }

    public function findRelatedSystems(Query $query, array $options)
    {
        return $query
            ->contain('GroupItems.Groups.Buckets.KitBuckets.Kits.Systems', function (Query $q) {
                return $q->find('listing');
            })
            ->formatResults(function (CollectionInterface $result) {
                return $result->map(function ($product) {
                    $product->related_systems = Hash::extract($product,
                        'group_items.{n}.group.buckets.{n}.kit_buckets.{n}.kit.systems.{n}');
                    unset($product->group_items);

                    return $product;
                });
            });
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

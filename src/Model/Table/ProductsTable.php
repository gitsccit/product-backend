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
 * @property \ProductBackend\Model\Table\ProductsRelationsTable&\Cake\ORM\Association\HasMany $ProductsRelations
 * @property \ProductBackend\Model\Table\SparesTable&\Cake\ORM\Association\HasMany $Spares
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\HasMany $Specifications
 * @property \ProductBackend\Model\Table\ViewProductBrowseImagesTable&\Cake\ORM\Association\HasMany $ViewProductBrowseImages
 * @property \ProductBackend\Model\Table\GenericsTable&\Cake\ORM\Association\BelongsToMany $Generics
 * @property \ProductBackend\Model\Table\ProductRulesTable&\Cake\ORM\Association\BelongsToMany $ProductRules
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
        $this->hasMany('ProductsRelations', [
            'foreignKey' => 'product_id',
            'className' => 'ProductBackend.ProductsRelations',
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
            ->nonNegativeInteger('product_category_id')
            ->allowEmptyString('product_category_id');

        $validator
            ->nonNegativeInteger('gallery_id')
            ->allowEmptyString('gallery_id');

        $validator
            ->nonNegativeInteger('manufacturer_id')
            ->allowEmptyString('manufacturer_id');

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
            ->nonNegativeInteger('status_id')
            ->allowEmptyString('status_id');

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
            ->nonNegativeInteger('ship_box_id')
            ->allowEmptyString('ship_box_id');

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
            ->nonNegativeInteger('country_of_origin_id')
            ->allowEmptyString('country_of_origin_id');

        $validator
            ->nonNegativeInteger('ship_from_id')
            ->allowEmptyString('ship_from_id');

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
        $rules->add($rules->existsIn('product_category_id', 'ProductCategories'), ['errorField' => 'product_category_id']);
        $rules->add($rules->existsIn('gallery_id', 'Galleries'), ['errorField' => 'gallery_id']);
        $rules->add($rules->existsIn('manufacturer_id', 'Manufacturers'), ['errorField' => 'manufacturer_id']);
        $rules->add($rules->existsIn('status_id', 'ProductStatuses'), ['errorField' => 'status_id']);
        $rules->add($rules->existsIn('ship_box_id', 'ShipBoxes'), ['errorField' => 'ship_box_id']);
        $rules->add($rules->existsIn('country_of_origin_id', 'Locations'), ['errorField' => 'country_of_origin_id']);
        $rules->add($rules->existsIn('ship_from_id', 'Locations'), ['errorField' => 'ship_from_id']);

        return $rules;
    }

    public function findBasic(Query $query, mixed ...$options)
    {
        $session = new Session();
        $perspectiveID = $options['perspective'] ?? $session->read('store.perspective');
        $priceLevelID = $options['priceLevel'] ?? $session->read('store.price_level');

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
                'Products.product_category_id',
                'url' => 'IFNULL(ProductPerspectives.url, Products.url)',
                'name' => 'IFNULL(ProductPerspectives.name, Products.name)',
                'price' => 'ProductPriceLevels.price',
                'Products.status_text',
                'ProductStatuses.warning',
                'status' => 'ProductStatuses.name',
                'Products.part_number',
            ])
            ->leftJoinWith('ProductPerspectives', function (Query $q) use ($perspectiveID) {
                return $q->where(['ProductPerspectives.perspective_id' => $perspectiveID]);
            })
            ->leftJoinWith('ProductStatuses')
            ->innerJoinWith('ProductPriceLevels', function (Query $q) use ($priceLevelID) {
                return $q->where([
                    'ProductPriceLevels.price_level_id' => $priceLevelID,
                ]);
            })
            ->group(['Products.id'])
            ->orderBy([
                'Products.sort' => 'ASC',
                'IFNULL(ProductPerspectives.name, Products.name)' => 'ASC',
            ]);
    }

    public function findActive(Query $query, mixed ...$options)
    {
        return $query
            ->find('basic', ...$options)
            ->where([
                'IFNULL(ProductPerspectives.active, Products.active) =' => 'yes',
            ]);
    }

    public function findCompare(Query $query, mixed ...$options)
    {
        return $query
            ->find('basic', ...$options)
            ->find('image', ...$options)
            ->find('specificationGroups', ...$options)
            ->select($this->Manufacturers)
            ->contain(['Manufacturers']);
    }

    public function findListing(Query $query, mixed ...$options)
    {
        return $query
            ->find('active', ...$options)
            ->find('image', ...$options)
            ->select([
                'Products.description',
                'show_related_systems' => "IFNULL(Products.show_related_systems, ProductCategories.show_related_systems) = 'yes'",
                'specs_overview' => $this->Specifications->find('overview')->where(['Specifications.product_id = Products.id']),
                'url' => 'IFNULL(ProductPerspectives.url, Products.url)',
                'name' => 'IFNULL(ProductPerspectives.name, Products.name)',
            ])
            ->select($this->Manufacturers)
            ->contain(['Manufacturers'])
            ->innerJoinWith('ProductCategories');
    }

    public function findDetails(Query $query, mixed ...$options)
    {
        return $query
            ->find('listing', ...$options)
            ->find('relatedSystems', ...$options)
            ->find('specificationGroups', ...$options)
            ->select(['Products.gallery_id'])
            ->select($this->Galleries)
            ->contain([
                'Galleries.GalleryImages' => function (Query $q) {
                    return $q
                        ->select([
                            'gallery_id',
                            'image_id' => 'file_id',
                        ])
                        ->where(['GalleryImages.active' => 'yes'])
                        ->orderBy('GalleryImages.sort');
                },
            ])
            ->formatResults(function ($result) {
                return $result->map(function ($product) {
                    $filesApiHandler = new \FilesApiHandler();
                    $product['gallery'] = array_values($filesApiHandler->getFileUrls(Hash::extract($product, 'gallery.gallery_images.{n}.image_id'), 300, 300));

                    return $product;
                });
            });
    }

    public function findImage(Query $query, mixed ...$options)
    {
        return $query
            ->select([
                'Products.id',
                'image_id' => 'ProductGalleryImages.file_id',
            ])
            ->leftJoinWith('Galleries.ProductGalleryImages')
            ->formatResults(function (CollectionInterface $results) {
                $filesApiHandler = new \FilesApiHandler();
                $results = json_decode(json_encode($results), true);
                $imagePathIdMap = array_filter(Hash::flatten($results), function ($key) {
                    return str_ends_with($key, 'image_id');
                }, ARRAY_FILTER_USE_KEY);
                $imageIDs = array_unique(array_values($imagePathIdMap));
                $images = $filesApiHandler->getFileUrls($imageIDs, 100, 100);

                foreach ($imagePathIdMap as $imagePath => $imageID) {
                    $results = Hash::insert($results, str_replace('image_id', 'image', $imagePath), $images[$imageID] ?? null);
                }

                return new Collection($results);
            });
    }

    public function findSpecifications(Query $query, mixed ...$options)
    {
        $session = new Session();
        $perspectiveID = $options['perspective'] ?? $session->read('store.perspective');
        $productCategoryID = $options['productCategoryID'];

        return $query
            ->select([
                'id' => 'SpecificationFields.id',
                'name' => 'SpecificationFields.name',
                'value' => 'Specifications.text_value',
                'count' => 'COUNT(DISTINCT Specifications.id)',
            ])
            ->leftJoinWith('ProductPerspectives', function (Query $q) use ($perspectiveID) {
                return $q->where(['ProductPerspectives.perspective_id' => $perspectiveID]);
            })
            ->innerJoinWith('Specifications.SpecificationFields.SpecificationGroups')
            ->leftJoinWith('Specifications.SpecificationUnits')
            ->where([
                'Products.product_category_id' => $productCategoryID,
                'IFNULL(ProductPerspectives.active, Products.active) =' => 'yes',
                'SpecificationFields.techspec' => 'yes',
            ])
            ->group(['SpecificationFields.id', 'Specifications.text_value'])
            ->orderBy([
                'SpecificationGroups.sort',
                'SpecificationGroups.name',
                'SpecificationFields.sort',
                'SpecificationGroups.name',
                'Specifications.sequence',
                'Specifications.sort',
                'Specifications.text_value',
            ])
            ->formatResults(function ($results) {
                return $results->groupBy('id')
                    ->map(function ($specificationSet) {
                        return [
                            'id' => $specificationSet[0]['id'],
                            'name' => $specificationSet[0]['name'],
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

    public function findSpecificationGroups(Query $query, mixed ...$options)
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
                    $product['specification_groups'] = (new Collection($product['specifications']))->groupBy('category')->toArray();

                    return $product;
                });
            });
    }

    public function findRelatedSystems(Query $query, mixed ...$options)
    {
        return $query
            ->contain('GroupItems.Groups.Buckets.KitBuckets.Kits.Systems', function (Query $q) {
                return $q->find('listing');
            })
            ->formatResults(function ($result) {
                return $result->map(function ($product) {
                    $product['related_systems'] = Hash::extract(
                        $product,
                        'group_items.{n}.group.buckets.{n}.kit_buckets.{n}.kit.systems.{n}'
                    );
                    unset($product['group_items']);

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

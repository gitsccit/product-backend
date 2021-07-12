<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Http\Session;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductCategories Model
 *
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\BelongsTo $ParentProductCategories
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\HasMany $ChildProductCategories
 * @property \ProductBackend\Model\Table\ProductCategoryPerspectivesTable&\Cake\ORM\Association\HasMany $ProductCategoryPerspectives
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\HasMany $Products
 * @property \ProductBackend\Model\Table\RaidMapsTable&\Cake\ORM\Association\HasMany $RaidMaps
 * @property \ProductBackend\Model\Table\SpareCategoryRelationsTable&\Cake\ORM\Association\HasMany $SpareCategoryRelations
 * @property \ProductBackend\Model\Table\ProductCategoryRelationsTable&\Cake\ORM\Association\BelongsToMany $RelatedProductCategories
 * @method \ProductBackend\Model\Entity\ProductCategory newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ProductCategory newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductCategoriesTable extends Table
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

        $this->setTable('product_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentProductCategories', [
            'className' => 'ProductBackend.ProductCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildProductCategories', [
            'className' => 'ProductBackend.ProductCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ProductCategoryPerspectives', [
            'foreignKey' => 'product_category_id',
            'className' => 'ProductBackend.ProductCategoryPerspectives',
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'product_category_id',
            'className' => 'ProductBackend.Products',
        ]);
        $this->hasMany('RaidMaps', [
            'foreignKey' => 'product_category_id',
            'className' => 'ProductBackend.RaidMaps',
        ]);
        $this->hasMany('SpareCategoryRelations', [
            'foreignKey' => 'product_category_id',
            'className' => 'ProductBackend.SpareCategoryRelations',
        ]);
        $this->belongsToMany('RelatedProductCategories', [
            'className' => 'ProductBackend.ProductCategories',
            'foreignKey' => 'product_category_id',
            'targetForeignKey' => 'related_product_category_id',
            'joinTable' => 'product_backend.product_category_relations',
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
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->nonNegativeInteger('gallery_priority')
            ->notEmptyString('gallery_priority');

        $validator
            ->scalar('show_related_systems')
            ->allowEmptyString('show_related_systems');

        $validator
            ->nonNegativeInteger('children')
            ->notEmptyString('children');

        $validator
            ->nonNegativeInteger('sort')
            ->notEmptyString('sort');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentProductCategories'), ['errorField' => 'parent_id']);

        return $rules;
    }

    public function findListing(Query $query, $options)
    {
        $session = new Session();
        $perspectiveId = $session->read('options.store.perspective');

        return $query
            ->select([
                'ProductCategories.id',
                'ProductCategories.description',
                'ProductCategories.parent_id',
                'url' => 'IFNULL(ProductCategoryPerspectives.url, ProductCategories.url)',
                'name' => 'IFNULL(ProductCategoryPerspectives.name, ProductCategories.name)',
                'product_count' => 'IFNULL(ProductCategoryPerspectives.children, ProductCategories.children)',
            ])
            ->leftJoinWith('ProductCategoryPerspectives', function (Query $query) use ($perspectiveId) {
                return $query->where([
                    'ProductCategoryPerspectives.perspective_id' => $perspectiveId,
                ]);
            })
            ->where([
                'IFNULL(ProductCategoryPerspectives.active, ProductCategories.active) =' => 'yes',
                'IFNULL(ProductCategoryPerspectives.children, ProductCategories.children) >' => 0,
            ])
            ->orderAsc('ProductCategories.sort');
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

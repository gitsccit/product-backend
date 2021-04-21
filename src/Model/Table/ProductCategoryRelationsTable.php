<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * ProductCategoryRelations Model
 *
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\BelongsTo $ProductCategories
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\BelongsTo $ProductCategories
 *
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryRelation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductCategoryRelationsTable extends Table
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

        $this->setTable('product_category_relations');

        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.ProductCategories',
        ]);
        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'related_product_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.ProductCategories',
        ]);
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
        $rules->add($rules->existsIn(['related_product_category_id'], 'ProductCategories'),
            ['errorField' => 'related_product_category_id']);

        return $rules;
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

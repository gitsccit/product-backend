<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * SpareCategoryRelations Model
 *
 * @property \ProductBackend\Model\Table\SpareCategoriesTable&\Cake\ORM\Association\BelongsTo $SpareCategories
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\BelongsTo $ProductCategories
 *
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategoryRelation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SpareCategoryRelationsTable extends Table
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

        $this->setTable('spare_category_relations');

        $this->belongsTo('SpareCategories', [
            'foreignKey' => 'spare_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.SpareCategories',
        ]);
        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
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
        $rules->add($rules->existsIn(['spare_category_id'], 'SpareCategories'), ['errorField' => 'spare_category_id']);
        $rules->add($rules->existsIn(['product_category_id'], 'ProductCategories'),
            ['errorField' => 'product_category_id']);

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

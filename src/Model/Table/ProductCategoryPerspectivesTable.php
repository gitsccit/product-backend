<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductCategoryPerspectives Model
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable&\Cake\ORM\Association\BelongsTo $Perspectives
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\BelongsTo $ProductCategories
 *
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductCategoryPerspective[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductCategoryPerspectivesTable extends Table
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

        $this->setTable('product_category_perspectives');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perspectives', [
            'foreignKey' => 'perspective_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Perspectives',
        ]);
        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.ProductCategories',
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
            ->nonNegativeInteger('perspective_id')
            ->notEmptyString('perspective_id');

        $validator
            ->nonNegativeInteger('product_category_id')
            ->notEmptyString('product_category_id');

        $validator
            ->scalar('url')
            ->maxLength('url', 80)
            ->allowEmptyString('url');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->allowEmptyString('name');

        $validator
            ->scalar('short_description')
            ->maxLength('short_description', 50)
            ->allowEmptyString('short_description');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->scalar('classification')
            ->maxLength('classification', 50)
            ->allowEmptyString('classification');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('show_related_systems')
            ->allowEmptyString('show_related_systems');

        $validator
            ->nonNegativeInteger('children')
            ->allowEmptyString('children');

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
        $rules->add($rules->existsIn('perspective_id', 'Perspectives'), ['errorField' => 'perspective_id']);
        $rules->add($rules->existsIn('product_category_id', 'ProductCategories'), ['errorField' => 'product_category_id']);

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

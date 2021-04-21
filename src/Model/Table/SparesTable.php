<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Spares Model
 *
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \ProductBackend\Model\Table\SpareCategoriesTable&\Cake\ORM\Association\BelongsTo $SpareCategories
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \ProductBackend\Model\Entity\Spare newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Spare newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Spare[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Spare get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Spare findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Spare patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Spare[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Spare|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Spare saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Spare[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Spare[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Spare[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Spare[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SparesTable extends Table
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

        $this->setTable('spares');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Products',
        ]);
        $this->belongsTo('SpareCategories', [
            'foreignKey' => 'spare_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.SpareCategories',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'related_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Products',
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
            ->scalar('active')
            ->notEmptyString('active');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn(['spare_category_id'], 'SpareCategories'), ['errorField' => 'spare_category_id']);
        $rules->add($rules->existsIn(['related_id'], 'Products'), ['errorField' => 'related_id']);

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

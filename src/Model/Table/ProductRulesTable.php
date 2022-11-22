<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductRules Model
 *
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \ProductBackend\Model\Entity\ProductRule newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ProductRule newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductRule[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductRulesTable extends Table
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

        $this->setTable('product_rules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Products',
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'product_rule_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'product_rules_products',
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
            ->nonNegativeInteger('product_id')
            ->notEmptyString('product_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('logic')
            ->requirePresence('logic', 'create')
            ->notEmptyString('logic');

        $validator
            ->scalar('relation')
            ->allowEmptyString('relation');

        $validator
            ->allowEmptyString('quantity');

        $validator
            ->scalar('condition')
            ->requirePresence('condition', 'create')
            ->notEmptyString('condition');

        $validator
            ->scalar('condition_relation')
            ->allowEmptyString('condition_relation');

        $validator
            ->allowEmptyString('condition_quantity');

        $validator
            ->scalar('action')
            ->requirePresence('action', 'create')
            ->notEmptyString('action');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
        $rules->add($rules->existsIn('product_id', 'Products'), ['errorField' => 'product_id']);

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

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerProducts Model
 *
 * @property \ProductBackend\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \ProductBackend\Model\Table\CustomerCategoriesTable&\Cake\ORM\Association\BelongsTo $CustomerCategories
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \ProductBackend\Model\Entity\CustomerProduct newEmptyEntity()
 * @method \ProductBackend\Model\Entity\CustomerProduct newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerProduct[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CustomerProductsTable extends Table
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

        $this->setTable('customer_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Customers',
        ]);
        $this->belongsTo('CustomerCategories', [
            'foreignKey' => 'customer_category_id',
            'className' => 'ProductBackend.CustomerCategories',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->nonNegativeInteger('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->nonNegativeInteger('customer_category_id')
            ->allowEmptyString('customer_category_id');

        $validator
            ->nonNegativeInteger('product_id')
            ->allowEmptyString('product_id');

        $validator
            ->scalar('sage_itemcode')
            ->maxLength('sage_itemcode', 30)
            ->allowEmptyString('sage_itemcode');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('show_stock')
            ->notEmptyString('show_stock');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

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
        $rules->add($rules->existsIn('customer_id', 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn('customer_category_id', 'CustomerCategories'), ['errorField' => 'customer_category_id']);
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

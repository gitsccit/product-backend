<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerCategories Model
 *
 * @property \ProductBackend\Model\Table\CustomerCategoriesTable&\Cake\ORM\Association\BelongsTo $ParentCustomerCategories
 * @property \ProductBackend\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \ProductBackend\Model\Table\CustomerBomsTable&\Cake\ORM\Association\HasMany $CustomerBoms
 * @property \ProductBackend\Model\Table\CustomerCategoriesTable&\Cake\ORM\Association\HasMany $ChildCustomerCategories
 * @property \ProductBackend\Model\Table\CustomerProductsTable&\Cake\ORM\Association\HasMany $CustomerProducts
 *
 * @method \ProductBackend\Model\Entity\CustomerCategory newEmptyEntity()
 * @method \ProductBackend\Model\Entity\CustomerCategory newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CustomerCategoriesTable extends Table
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

        $this->setTable('customer_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentCustomerCategories', [
            'className' => 'ProductBackend.CustomerCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Customers',
        ]);
        $this->hasMany('CustomerBoms', [
            'foreignKey' => 'customer_category_id',
            'className' => 'ProductBackend.CustomerBoms',
        ]);
        $this->hasMany('ChildCustomerCategories', [
            'className' => 'ProductBackend.CustomerCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('CustomerProducts', [
            'foreignKey' => 'customer_category_id',
            'className' => 'ProductBackend.CustomerProducts',
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
            ->nonNegativeInteger('parent_id')
            ->allowEmptyString('parent_id');

        $validator
            ->nonNegativeInteger('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

        $validator
            ->nonNegativeInteger('children')
            ->notEmptyString('children');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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
        $rules->add($rules->existsIn('parent_id', 'ParentCustomerCategories'), ['errorField' => 'parent_id']);
        $rules->add($rules->existsIn('customer_id', 'Customers'), ['errorField' => 'customer_id']);

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

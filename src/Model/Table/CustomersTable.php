<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable&\Cake\ORM\Association\BelongsTo $Perspectives
 * @property \ProductBackend\Model\Table\CustomerBomsTable&\Cake\ORM\Association\HasMany $CustomerBoms
 * @property \ProductBackend\Model\Table\CustomerCategoriesTable&\Cake\ORM\Association\HasMany $CustomerCategories
 * @property \ProductBackend\Model\Table\CustomerProductsTable&\Cake\ORM\Association\HasMany $CustomerProducts
 *
 * @method \ProductBackend\Model\Entity\Customer newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Customer newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Customer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Customer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Customer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Customer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CustomersTable extends Table
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

        $this->setTable('customers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.Perspectives',
        ]);
        $this->hasMany('CustomerBoms', [
            'foreignKey' => 'customer_id',
            'className' => 'ProductBackend.CustomerBoms',
        ]);
        $this->hasMany('CustomerCategories', [
            'foreignKey' => 'customer_id',
            'className' => 'ProductBackend.CustomerCategories',
        ]);
        $this->hasMany('CustomerProducts', [
            'foreignKey' => 'customer_id',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->nonNegativeInteger('crm_account')
            ->allowEmptyString('crm_account');

        $validator
            ->scalar('sage_customer')
            ->maxLength('sage_customer', 23)
            ->allowEmptyString('sage_customer');

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
        $rules->add($rules->existsIn(['perspective_id'], 'Perspectives'), ['errorField' => 'perspective_id']);

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

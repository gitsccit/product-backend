<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerBoms Model
 *
 * @property \ProductBackend\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \ProductBackend\Model\Table\CustomerCategoriesTable&\Cake\ORM\Association\BelongsTo $CustomerCategories
 * @property \ProductBackend\Model\Table\LocationsTable&\Cake\ORM\Association\BelongsTo $Locations
 * @property \ProductBackend\Model\Table\ImagesTable&\Cake\ORM\Association\BelongsTo $Images
 * @property \ProductBackend\Model\Table\CustomerBomDetailsTable&\Cake\ORM\Association\HasMany $CustomerBomDetails
 * @method \ProductBackend\Model\Entity\CustomerBom newEmptyEntity()
 * @method \ProductBackend\Model\Entity\CustomerBom newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBom[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CustomerBomsTable extends Table
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

        $this->setTable('customer_boms');
        $this->setDisplayField('name');
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
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'className' => 'ProductBackend.Locations',
        ]);
        $this->belongsTo('Images', [
            'foreignKey' => 'image_id',
            'className' => 'ProductBackend.Images',
        ]);
        $this->hasMany('CustomerBomDetails', [
            'foreignKey' => 'customer_bom_id',
            'className' => 'ProductBackend.CustomerBomDetails',
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
            ->maxLength('name', 60)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('bstock')
            ->notEmptyString('bstock');

        $validator
            ->numeric('price')
            ->greaterThanOrEqual('price', 0)
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->scalar('palletship')
            ->notEmptyString('palletship');

        $validator
            ->numeric('weight')
            ->greaterThanOrEqual('weight', 0)
            ->requirePresence('weight', 'create')
            ->notEmptyString('weight');

        $validator
            ->numeric('length')
            ->requirePresence('length', 'create')
            ->notEmptyString('length');

        $validator
            ->numeric('width')
            ->requirePresence('width', 'create')
            ->notEmptyString('width');

        $validator
            ->numeric('height')
            ->requirePresence('height', 'create')
            ->notEmptyString('height');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);
        $rules->add(
            $rules->existsIn(['customer_category_id'], 'CustomerCategories'),
            ['errorField' => 'customer_category_id']
        );
        $rules->add($rules->existsIn(['location_id'], 'Locations'), ['errorField' => 'location_id']);
        $rules->add($rules->existsIn(['image_id'], 'Images'), ['errorField' => 'image_id']);

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

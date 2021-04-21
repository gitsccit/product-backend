<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Generics Model
 *
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \ProductBackend\Model\Entity\Generic newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Generic newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Generic[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Generic get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Generic findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Generic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Generic[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Generic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Generic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Generic[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Generic[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Generic[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Generic[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class GenericsTable extends Table
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

        $this->setTable('generics');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Products',
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'generic_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'generics_products',
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
            ->scalar('sage_itemcode')
            ->maxLength('sage_itemcode', 30)
            ->requirePresence('sage_itemcode', 'create')
            ->notEmptyString('sage_itemcode');

        $validator
            ->numeric('cost')
            ->greaterThanOrEqual('cost', 0)
            ->notEmptyString('cost');

        $validator
            ->scalar('cost_maintenance')
            ->notEmptyString('cost_maintenance');

        $validator
            ->scalar('prioritize')
            ->notEmptyString('prioritize');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);

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

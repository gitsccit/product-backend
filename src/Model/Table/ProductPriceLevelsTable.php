<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductPriceLevels Model
 *
 * @property \ProductBackend\Model\Table\PriceLevelsTable&\Cake\ORM\Association\BelongsTo $PriceLevels
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \ProductBackend\Model\Entity\ProductPriceLevel newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ProductPriceLevel newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductPriceLevel[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductPriceLevelsTable extends Table
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

        $this->setTable('product_price_levels');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PriceLevels', [
            'foreignKey' => 'price_level_id',
            'className' => 'ProductBackend.PriceLevels',
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
            ->nonNegativeInteger('price_level_id')
            ->allowEmptyString('price_level_id');

        $validator
            ->nonNegativeInteger('product_id')
            ->allowEmptyString('product_id');

        $validator
            ->scalar('logic')
            ->notEmptyString('logic');

        $validator
            ->numeric('value')
            ->allowEmptyString('value');

        $validator
            ->numeric('price')
            ->notEmptyString('price');

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
        $rules->add($rules->existsIn('price_level_id', 'PriceLevels'), ['errorField' => 'price_level_id']);
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

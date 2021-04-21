<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemPriceLevels Model
 *
 * @property \ProductBackend\Model\Table\PriceLevelsTable&\Cake\ORM\Association\BelongsTo $PriceLevels
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\BelongsTo $Systems
 *
 * @method \ProductBackend\Model\Entity\SystemPriceLevel newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SystemPriceLevel newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPriceLevel[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemPriceLevelsTable extends Table
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

        $this->setTable('system_price_levels');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PriceLevels', [
            'foreignKey' => 'price_level_id',
            'className' => 'ProductBackend.PriceLevels',
        ]);
        $this->belongsTo('Systems', [
            'foreignKey' => 'system_id',
            'className' => 'ProductBackend.Systems',
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
            ->scalar('logic')
            ->notEmptyString('logic');

        $validator
            ->numeric('value')
            ->allowEmptyString('value');

        $validator
            ->numeric('fpa')
            ->allowEmptyString('fpa');

        $validator
            ->numeric('price')
            ->allowEmptyString('price');

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
        $rules->add($rules->existsIn(['price_level_id'], 'PriceLevels'), ['errorField' => 'price_level_id']);
        $rules->add($rules->existsIn(['system_id'], 'Systems'), ['errorField' => 'system_id']);

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

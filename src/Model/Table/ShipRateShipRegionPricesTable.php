<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShipRateShipRegionPrices Model
 *
 * @property \ProductBackend\Model\Table\ShipRatesTable&\Cake\ORM\Association\BelongsTo $ShipRates
 * @property \ProductBackend\Model\Table\ShipRegionsTable&\Cake\ORM\Association\BelongsTo $ShipRegions
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRateShipRegionPrice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ShipRateShipRegionPricesTable extends Table
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

        $this->setTable('ship_rate_ship_region_prices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ShipRates', [
            'foreignKey' => 'ship_rate_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.ShipRates',
        ]);
        $this->belongsTo('ShipRegions', [
            'foreignKey' => 'ship_region_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.ShipRegions',
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
            ->decimal('price')
            ->greaterThanOrEqual('price', 0)
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

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
        $rules->add($rules->existsIn(['ship_rate_id'], 'ShipRates'), ['errorField' => 'ship_rate_id']);
        $rules->add($rules->existsIn(['ship_region_id'], 'ShipRegions'), ['errorField' => 'ship_region_id']);

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

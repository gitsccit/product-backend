<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShipRegions Model
 *
 * @property \ProductBackend\Model\Table\ShipRateShipRegionPricesTable&\Cake\ORM\Association\HasMany $ShipRateShipRegionPrices
 * @property \ProductBackend\Model\Table\ShipRegionLocationsTable&\Cake\ORM\Association\HasMany $ShipRegionLocations
 *
 * @method \ProductBackend\Model\Entity\ShipRegion newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ShipRegion newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRegion[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ShipRegionsTable extends Table
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

        $this->setTable('ship_regions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ShipRateShipRegionPrices', [
            'foreignKey' => 'ship_region_id',
            'className' => 'ProductBackend.ShipRateShipRegionPrices',
        ]);
        $this->hasMany('ShipRegionLocations', [
            'foreignKey' => 'ship_region_id',
            'className' => 'ProductBackend.ShipRegionLocations',
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
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('ship_box_only')
            ->notEmptyString('ship_box_only');

        return $validator;
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

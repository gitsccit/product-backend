<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShipRates Model
 *
 * @property \ProductBackend\Model\Table\ShipRateShipRegionPricesTable&\Cake\ORM\Association\HasMany $ShipRateShipRegionPrices
 * @property \ProductBackend\Model\Table\ShipBoxesTable&\Cake\ORM\Association\BelongsToMany $ShipBoxes
 * @method \ProductBackend\Model\Entity\ShipRate newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ShipRate newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipRate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ShipRatesTable extends Table
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

        $this->setTable('ship_rates');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ShipRateShipRegionPrices', [
            'foreignKey' => 'ship_rate_id',
            'className' => 'ProductBackend.ShipRateShipRegionPrices',
        ]);
        $this->belongsToMany('ShipBoxes', [
            'foreignKey' => 'ship_rate_id',
            'targetForeignKey' => 'ship_box_id',
            'joinTable' => 'ship_boxes_ship_rates',
            'className' => 'ProductBackend.ShipBoxes',
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
            ->scalar('description')
            ->maxLength('description', 120)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('sage_shipvia')
            ->maxLength('sage_shipvia', 15)
            ->requirePresence('sage_shipvia', 'create')
            ->notEmptyString('sage_shipvia');

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

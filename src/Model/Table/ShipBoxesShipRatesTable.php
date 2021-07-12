<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * ShipBoxesShipRates Model
 *
 * @property \ProductBackend\Model\Table\ShipBoxesTable&\Cake\ORM\Association\BelongsTo $ShipBoxes
 * @property \ProductBackend\Model\Table\ShipRatesTable&\Cake\ORM\Association\BelongsTo $ShipRates
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBoxesShipRate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ShipBoxesShipRatesTable extends Table
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

        $this->setTable('ship_boxes_ship_rates');

        $this->belongsTo('ShipBoxes', [
            'foreignKey' => 'ship_box_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.ShipBoxes',
        ]);
        $this->belongsTo('ShipRates', [
            'foreignKey' => 'ship_rate_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.ShipRates',
        ]);
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
        $rules->add($rules->existsIn(['ship_box_id'], 'ShipBoxes'), ['errorField' => 'ship_box_id']);
        $rules->add($rules->existsIn(['ship_rate_id'], 'ShipRates'), ['errorField' => 'ship_rate_id']);

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

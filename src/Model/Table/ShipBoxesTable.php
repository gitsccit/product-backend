<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShipBoxes Model
 *
 * @property \ProductBackend\Model\Table\KitsTable&\Cake\ORM\Association\HasMany $Kits
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\HasMany $Products
 * @property \ProductBackend\Model\Table\ShipRatesTable&\Cake\ORM\Association\BelongsToMany $ShipRates
 *
 * @method \ProductBackend\Model\Entity\ShipBox newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ShipBox newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ShipBox[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ShipBoxesTable extends Table
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

        $this->setTable('ship_boxes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Kits', [
            'foreignKey' => 'ship_box_id',
            'className' => 'ProductBackend.Kits',
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'ship_box_id',
            'className' => 'ProductBackend.Products',
        ]);
        $this->belongsToMany('ShipRates', [
            'foreignKey' => 'ship_box_id',
            'targetForeignKey' => 'ship_rate_id',
            'joinTable' => 'ship_boxes_ship_rates',
            'className' => 'ProductBackend.ShipRates',
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
            ->numeric('length')
            ->allowEmptyString('length');

        $validator
            ->numeric('width')
            ->allowEmptyString('width');

        $validator
            ->numeric('height')
            ->allowEmptyString('height');

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

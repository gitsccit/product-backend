<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RaidMaps Model
 *
 * @property \ProductBackend\Model\Table\ProductCategoriesTable&\Cake\ORM\Association\BelongsTo $ProductCategories
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $InterfaceSpecs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $Interface2Specs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $NameSpecs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $RaidSpecs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $PortsSpecs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $DevicesSpecs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $PergroupSpecs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $CapacitySpecs
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\BelongsTo $BackplaneSpecs
 * @method \ProductBackend\Model\Entity\RaidMap newEmptyEntity()
 * @method \ProductBackend\Model\Entity\RaidMap newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\RaidMap[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RaidMapsTable extends Table
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

        $this->setTable('raid_maps');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'ProductBackend.ProductCategories',
        ]);
        $this->belongsTo('InterfaceSpecs', [
            'foreignKey' => 'interface_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('Interface2Specs', [
            'foreignKey' => 'interface2_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('NameSpecs', [
            'foreignKey' => 'name_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('RaidSpecs', [
            'foreignKey' => 'raid_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('PortsSpecs', [
            'foreignKey' => 'ports_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('DevicesSpecs', [
            'foreignKey' => 'devices_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('PergroupSpecs', [
            'foreignKey' => 'pergroup_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('CapacitySpecs', [
            'foreignKey' => 'capacity_spec_id',
            'className' => 'ProductBackend.Specifications',
        ]);
        $this->belongsTo('BackplaneSpecs', [
            'foreignKey' => 'backplane_spec_id',
            'className' => 'ProductBackend.Specifications',
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
            ->scalar('device')
            ->requirePresence('device', 'create')
            ->notEmptyString('device');

        $validator
            ->scalar('interface')
            ->allowEmptyString('interface');

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
        $rules->add(
            $rules->existsIn(['product_category_id'], 'ProductCategories'),
            ['errorField' => 'product_category_id']
        );
        $rules->add($rules->existsIn(['interface_spec_id'], 'InterfaceSpecs'), ['errorField' => 'interface_spec_id']);
        $rules->add(
            $rules->existsIn(['interface2_spec_id'], 'Interface2Specs'),
            ['errorField' => 'interface2_spec_id']
        );
        $rules->add($rules->existsIn(['name_spec_id'], 'NameSpecs'), ['errorField' => 'name_spec_id']);
        $rules->add($rules->existsIn(['raid_spec_id'], 'RaidSpecs'), ['errorField' => 'raid_spec_id']);
        $rules->add($rules->existsIn(['ports_spec_id'], 'PortsSpecs'), ['errorField' => 'ports_spec_id']);
        $rules->add($rules->existsIn(['devices_spec_id'], 'DevicesSpecs'), ['errorField' => 'devices_spec_id']);
        $rules->add($rules->existsIn(['pergroup_spec_id'], 'PergroupSpecs'), ['errorField' => 'pergroup_spec_id']);
        $rules->add($rules->existsIn(['capacity_spec_id'], 'CapacitySpecs'), ['errorField' => 'capacity_spec_id']);
        $rules->add($rules->existsIn(['backplane_spec_id'], 'BackplaneSpecs'), ['errorField' => 'backplane_spec_id']);

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

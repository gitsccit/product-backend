<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpecificationUnitGroups Model
 *
 * @property \ProductBackend\Model\Table\SpecificationFieldsTable&\Cake\ORM\Association\HasMany $SpecificationFields
 * @property \ProductBackend\Model\Table\SpecificationUnitsTable&\Cake\ORM\Association\HasMany $SpecificationUnits
 *
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnitGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SpecificationUnitGroupsTable extends Table
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

        $this->setTable('specification_unit_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('SpecificationFields', [
            'foreignKey' => 'specification_unit_group_id',
            'className' => 'ProductBackend.SpecificationFields',
        ]);
        $this->hasMany('SpecificationUnits', [
            'foreignKey' => 'specification_unit_group_id',
            'className' => 'ProductBackend.SpecificationUnits',
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

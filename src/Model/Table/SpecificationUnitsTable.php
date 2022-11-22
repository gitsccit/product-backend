<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpecificationUnits Model
 *
 * @property \ProductBackend\Model\Table\SpecificationUnitGroupsTable&\Cake\ORM\Association\BelongsTo $SpecificationUnitGroups
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\HasMany $Specifications
 *
 * @method \ProductBackend\Model\Entity\SpecificationUnit newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SpecificationUnit newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationUnit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SpecificationUnitsTable extends Table
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

        $this->setTable('specification_units');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('SpecificationUnitGroups', [
            'foreignKey' => 'specification_unit_group_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.SpecificationUnitGroups',
        ]);
        $this->hasMany('Specifications', [
            'foreignKey' => 'specification_unit_id',
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
            ->nonNegativeInteger('specification_unit_group_id')
            ->notEmptyString('specification_unit_group_id');

        $validator
            ->scalar('symbol')
            ->maxLength('symbol', 5)
            ->requirePresence('symbol', 'create')
            ->notEmptyString('symbol');

        $validator
            ->scalar('name')
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 30)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->decimal('multiplier')
            ->requirePresence('multiplier', 'create')
            ->notEmptyString('multiplier');

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
        $rules->add($rules->existsIn('specification_unit_group_id', 'SpecificationUnitGroups'), ['errorField' => 'specification_unit_group_id']);

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

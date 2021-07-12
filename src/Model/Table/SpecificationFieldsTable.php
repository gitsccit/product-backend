<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpecificationFields Model
 *
 * @property \ProductBackend\Model\Table\SpecificationGroupsTable&\Cake\ORM\Association\BelongsTo $SpecificationGroups
 * @property \ProductBackend\Model\Table\SpecificationUnitGroupsTable&\Cake\ORM\Association\BelongsTo $SpecificationUnitGroups
 * @property \ProductBackend\Model\Table\SpecificationsTable&\Cake\ORM\Association\HasMany $Specifications
 * @method \ProductBackend\Model\Entity\SpecificationField newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SpecificationField newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpecificationField[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SpecificationFieldsTable extends Table
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

        $this->setTable('specification_fields');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('SpecificationGroups', [
            'foreignKey' => 'specification_group_id',
            'className' => 'ProductBackend.SpecificationGroups',
        ]);
        $this->belongsTo('SpecificationUnitGroups', [
            'foreignKey' => 'specification_unit_group_id',
            'className' => 'ProductBackend.SpecificationUnitGroups',
        ]);
        $this->hasMany('Specifications', [
            'foreignKey' => 'specification_field_id',
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
            ->scalar('techspec')
            ->notEmptyString('techspec');

        $validator
            ->scalar('name')
            ->maxLength('name', 60)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('label')
            ->maxLength('label', 8)
            ->requirePresence('label', 'create')
            ->notEmptyString('label');

        $validator
            ->scalar('description')
            ->maxLength('description', 120)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->nonNegativeInteger('sort')
            ->notEmptyString('sort');

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
            $rules->existsIn(['specification_group_id'], 'SpecificationGroups'),
            ['errorField' => 'specification_group_id']
        );
        $rules->add(
            $rules->existsIn(['specification_unit_group_id'], 'SpecificationUnitGroups'),
            ['errorField' => 'specification_unit_group_id']
        );

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

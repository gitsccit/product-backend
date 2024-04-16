<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Specifications Model
 *
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \ProductBackend\Model\Table\SpecificationFieldsTable&\Cake\ORM\Association\BelongsTo $SpecificationFields
 * @property \ProductBackend\Model\Table\SpecificationUnitsTable&\Cake\ORM\Association\BelongsTo $SpecificationUnits
 *
 * @method \ProductBackend\Model\Entity\Specification newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Specification newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Specification[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Specification get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Specification findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Specification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Specification[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Specification|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Specification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Specification[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Specification[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Specification[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Specification[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SpecificationsTable extends Table
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

        $this->setTable('specifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Products',
        ]);
        $this->belongsTo('SpecificationFields', [
            'foreignKey' => 'specification_field_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.SpecificationFields',
        ]);
        $this->belongsTo('SpecificationUnits', [
            'foreignKey' => 'specification_unit_id',
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
            ->nonNegativeInteger('product_id')
            ->notEmptyString('product_id');

        $validator
            ->nonNegativeInteger('specification_field_id')
            ->notEmptyString('specification_field_id');

        $validator
            ->notEmptyString('sequence');

        $validator
            ->nonNegativeInteger('specification_unit_id')
            ->allowEmptyString('specification_unit_id');

        $validator
            ->scalar('text_value')
            ->maxLength('text_value', 120)
            ->requirePresence('text_value', 'create')
            ->notEmptyString('text_value');

        $validator
            ->numeric('unit_value')
            ->allowEmptyString('unit_value');

        $validator
            ->numeric('sort')
            ->allowEmptyString('sort');

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
        $rules->add($rules->existsIn('product_id', 'Products'), ['errorField' => 'product_id']);
        $rules->add($rules->existsIn('specification_field_id', 'SpecificationFields'), ['errorField' => 'specification_field_id']);
        $rules->add($rules->existsIn('specification_unit_id', 'SpecificationUnits'), ['errorField' => 'specification_unit_id']);

        return $rules;
    }

    public function findSpecifications(Query $query, array $options)
    {
        $query
            ->select([
                'id' => 'SpecificationFields.id',
                'Specifications.product_id',
                'name' => 'SpecificationFields.name',
                'value' => 'Specifications.text_value',
            ])
            ->innerJoinWith('SpecificationFields.SpecificationGroups')
            ->orderBy([
                'SpecificationGroups.sort',
                'SpecificationGroups.name',
                'SpecificationFields.sort',
                'SpecificationGroups.name',
                'Specifications.sequence',
                'Specifications.sort',
                'Specifications.text_value',
            ]);

        if ($options['onlyShowTechSpec'] ?? true) {
            $query->where([
                'SpecificationFields.techspec' => 'yes',
            ]);
        }

        return $query;
    }

    public function findOverview(Query $query, array $options)
    {
        return $query
            ->select([
                'description' => "GROUP_CONCAT(Specifications.text_value ORDER BY
                         SpecificationGroups.sort ASC, SpecificationFields.sort ASC, Specifications.sort ASC
                         SEPARATOR ', ')",
            ])
            ->innerJoinWith('SpecificationFields.SpecificationGroups')
            ->group('Specifications.product_id')
            ->limit(10);
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

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemRuleDetails Model
 *
 * @property \ProductBackend\Model\Table\SystemRulesTable&\Cake\ORM\Association\BelongsTo $SystemRules
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\BelongsTo $Buckets
 * @property \ProductBackend\Model\Table\GroupItemsTable&\Cake\ORM\Association\BelongsTo $GroupItems
 * @method \ProductBackend\Model\Entity\SystemRuleDetail newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SystemRuleDetail newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRuleDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemRuleDetailsTable extends Table
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

        $this->setTable('system_rule_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SystemRules', [
            'foreignKey' => 'system_rule_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Buckets', [
            'foreignKey' => 'bucket_id',
        ]);
        $this->belongsTo('GroupItems', [
            'foreignKey' => 'group_item_id',
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
            ->scalar('logic')
            ->requirePresence('logic', 'create')
            ->notEmptyString('logic');

        $validator
            ->scalar('relation')
            ->allowEmptyString('relation');

        $validator
            ->nonNegativeInteger('value')
            ->allowEmptyString('value');

        $validator
            ->nonNegativeInteger('sort')
            ->requirePresence('sort', 'create')
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
        $rules->add($rules->existsIn(['system_rule_id'], 'SystemRules'));
        $rules->add($rules->existsIn(['bucket_id'], 'Buckets'));
        $rules->add($rules->existsIn(['group_item_id'], 'GroupItems'));

        return $rules;
    }

    public static function defaultConnectionName(): string
    {
        return 'product_backend';
    }
}

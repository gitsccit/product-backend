<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KitRuleDetails Model
 *
 * @property \ProductBackend\Model\Table\KitRulesTable&\Cake\ORM\Association\BelongsTo $KitRules
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\BelongsTo $Buckets
 * @property \ProductBackend\Model\Table\GroupItemsTable&\Cake\ORM\Association\BelongsTo $GroupItems
 * @method \ProductBackend\Model\Entity\KitRuleDetail newEmptyEntity()
 * @method \ProductBackend\Model\Entity\KitRuleDetail newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitRuleDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class KitRuleDetailsTable extends Table
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

        $this->setTable('kit_rule_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('KitRules', [
            'foreignKey' => 'kit_rule_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.KitRules',
        ]);
        $this->belongsTo('Buckets', [
            'foreignKey' => 'bucket_id',
            'className' => 'ProductBackend.Buckets',
        ]);
        $this->belongsTo('GroupItems', [
            'foreignKey' => 'group_item_id',
            'className' => 'ProductBackend.GroupItems',
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
        $rules->add($rules->existsIn(['kit_rule_id'], 'KitRules'), ['errorField' => 'kit_rule_id']);
        $rules->add($rules->existsIn(['bucket_id'], 'Buckets'), ['errorField' => 'bucket_id']);
        $rules->add($rules->existsIn(['group_item_id'], 'GroupItems'), ['errorField' => 'group_item_id']);

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

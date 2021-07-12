<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SkuRules Model
 *
 * @property \ProductBackend\Model\Table\SkuRuleCategoriesTable&\Cake\ORM\Association\BelongsTo $SkuRuleCategories
 * @property \ProductBackend\Model\Table\SkuRuleGroupsTable&\Cake\ORM\Association\BelongsTo $SkuRuleGroups
 * @property \ProductBackend\Model\Table\SkuRuleAdditionalSkusTable&\Cake\ORM\Association\HasMany $SkuRuleAdditionalSkus
 * @property \ProductBackend\Model\Table\SkuRuleGroupsTable&\Cake\ORM\Association\HasMany $SkuRuleGroups
 * @property \ProductBackend\Model\Table\SkuRulesFilesTable&\Cake\ORM\Association\HasMany $SkuRulesFiles
 * @method \ProductBackend\Model\Entity\SkuRule newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SkuRule newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRule[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SkuRulesTable extends Table
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

        $this->setTable('sku_rules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('SkuRuleCategories', [
            'foreignKey' => 'sku_rule_category_id',
            'className' => 'ProductBackend.SkuRuleCategories',
        ]);
        $this->belongsTo('SkuRuleGroups', [
            'foreignKey' => 'sku_rule_group_id',
            'className' => 'ProductBackend.SkuRuleGroups',
        ]);
        $this->hasMany('SkuRuleAdditionalSkus', [
            'foreignKey' => 'sku_rule_id',
            'className' => 'ProductBackend.SkuRuleAdditionalSkus',
        ]);
        $this->hasMany('SkuRuleGroups', [
            'foreignKey' => 'sku_rule_id',
            'className' => 'ProductBackend.SkuRuleGroups',
        ]);
        $this->hasMany('SkuRulesFiles', [
            'foreignKey' => 'sku_rule_id',
            'className' => 'ProductBackend.SkuRulesFiles',
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
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('scheduler_notes')
            ->allowEmptyString('scheduler_notes');

        $validator
            ->scalar('eval_logic')
            ->allowEmptyString('eval_logic');

        $validator
            ->allowEmptyString('eval_quantity');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

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
            $rules->existsIn(['sku_rule_category_id'], 'SkuRuleCategories'),
            ['errorField' => 'sku_rule_category_id']
        );
        $rules->add($rules->existsIn(['sku_rule_group_id'], 'SkuRuleGroups'), ['errorField' => 'sku_rule_group_id']);

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

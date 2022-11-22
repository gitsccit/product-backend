<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SkuRuleGroups Model
 *
 * @property \ProductBackend\Model\Table\SkuRulesTable&\Cake\ORM\Association\BelongsTo $SkuRules
 * @property \ProductBackend\Model\Table\SkuRuleAdditionalSkusTable&\Cake\ORM\Association\HasMany $SkuRuleAdditionalSkus
 * @property \ProductBackend\Model\Table\SkuRuleGroupSkusTable&\Cake\ORM\Association\HasMany $SkuRuleGroupSkus
 * @property \ProductBackend\Model\Table\SkuRulesTable&\Cake\ORM\Association\HasMany $SkuRules
 *
 * @method \ProductBackend\Model\Entity\SkuRuleGroup newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SkuRuleGroup newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SkuRuleGroupsTable extends Table
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

        $this->setTable('sku_rule_groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SkuRules', [
            'foreignKey' => 'sku_rule_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.SkuRules',
        ]);
        $this->hasMany('SkuRuleAdditionalSkus', [
            'foreignKey' => 'sku_rule_group_id',
            'className' => 'ProductBackend.SkuRuleAdditionalSkus',
        ]);
        $this->hasMany('SkuRuleGroupSkus', [
            'foreignKey' => 'sku_rule_group_id',
            'className' => 'ProductBackend.SkuRuleGroupSkus',
        ]);
        $this->hasMany('SkuRules', [
            'foreignKey' => 'sku_rule_group_id',
            'className' => 'ProductBackend.SkuRules',
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
            ->nonNegativeInteger('sku_rule_id')
            ->notEmptyString('sku_rule_id');

        $validator
            ->scalar('method')
            ->notEmptyString('method');

        $validator
            ->nonNegativeInteger('spec_id')
            ->allowEmptyString('spec_id');

        $validator
            ->scalar('value')
            ->maxLength('value', 20)
            ->allowEmptyString('value');

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
        $rules->add($rules->existsIn('sku_rule_id', 'SkuRules'), ['errorField' => 'sku_rule_id']);

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

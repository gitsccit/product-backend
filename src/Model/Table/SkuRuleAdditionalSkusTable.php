<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SkuRuleAdditionalSkus Model
 *
 * @property \ProductBackend\Model\Table\SkuRulesTable&\Cake\ORM\Association\BelongsTo $SkuRules
 * @property \ProductBackend\Model\Table\SkuRuleGroupsTable&\Cake\ORM\Association\BelongsTo $SkuRuleGroups
 *
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleAdditionalSkus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SkuRuleAdditionalSkusTable extends Table
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

        $this->setTable('sku_rule_additional_skus');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SkuRules', [
            'foreignKey' => 'sku_rule_id',
            'className' => 'ProductBackend.SkuRules',
        ]);
        $this->belongsTo('SkuRuleGroups', [
            'foreignKey' => 'sku_rule_group_id',
            'className' => 'ProductBackend.SkuRuleGroups',
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
            ->allowEmptyString('sku_rule_id');

        $validator
            ->allowEmptyString('quantity');

        $validator
            ->scalar('sage_itemcode')
            ->maxLength('sage_itemcode', 30)
            ->requirePresence('sage_itemcode', 'create')
            ->notEmptyString('sage_itemcode');

        $validator
            ->nonNegativeInteger('sku_rule_group_id')
            ->allowEmptyString('sku_rule_group_id');

        $validator
            ->allowEmptyString('quantity_modifier');

        $validator
            ->scalar('sell_price')
            ->notEmptyString('sell_price');

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
        $rules->add($rules->existsIn('sku_rule_group_id', 'SkuRuleGroups'), ['errorField' => 'sku_rule_group_id']);

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

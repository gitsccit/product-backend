<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SkuRuleCategories Model
 *
 * @property \ProductBackend\Model\Table\SkuRuleCategoriesTable&\Cake\ORM\Association\BelongsTo $ParentSkuRuleCategories
 * @property \ProductBackend\Model\Table\SkuRuleCategoriesTable&\Cake\ORM\Association\HasMany $ChildSkuRuleCategories
 * @property \ProductBackend\Model\Table\SkuRulesTable&\Cake\ORM\Association\HasMany $SkuRules
 *
 * @method \ProductBackend\Model\Entity\SkuRuleCategory newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SkuRuleCategory newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRuleCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SkuRuleCategoriesTable extends Table
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

        $this->setTable('sku_rule_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentSkuRuleCategories', [
            'className' => 'ProductBackend.SkuRuleCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildSkuRuleCategories', [
            'className' => 'ProductBackend.SkuRuleCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('SkuRules', [
            'foreignKey' => 'sku_rule_category_id',
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
            ->nonNegativeInteger('parent_id')
            ->allowEmptyString('parent_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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
        $rules->add($rules->existsIn('parent_id', 'ParentSkuRuleCategories'), ['errorField' => 'parent_id']);

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

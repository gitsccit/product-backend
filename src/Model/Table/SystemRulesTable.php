<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemRules Model
 *
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\BelongsTo $Systems
 * @property \ProductBackend\Model\Table\SystemRuleDetailsTable&\Cake\ORM\Association\HasMany $SystemRuleDetails
 * @method \ProductBackend\Model\Entity\SystemRule newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SystemRule newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemRule[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemRulesTable extends Table
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

        $this->setTable('system_rules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Systems', [
            'foreignKey' => 'system_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('SystemRuleDetails', [
            'foreignKey' => 'system_rule_id',
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
            ->scalar('action')
            ->requirePresence('action', 'create')
            ->notEmptyString('action');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
        $rules->add($rules->existsIn(['system_id'], 'Systems'));

        return $rules;
    }

    public static function defaultConnectionName(): string
    {
        return 'product_backend';
    }
}

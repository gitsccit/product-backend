<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemItems Model
 *
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\BelongsTo $Systems
 * @property \ProductBackend\Model\Table\GroupItemsTable&\Cake\ORM\Association\BelongsTo $GroupItems
 *
 * @method \ProductBackend\Model\Entity\SystemItem newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SystemItem newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemItemsTable extends Table
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

        $this->setTable('system_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Systems', [
            'foreignKey' => 'system_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Systems',
        ]);
        $this->belongsTo('GroupItems', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
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
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

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
        $rules->add($rules->existsIn(['system_id'], 'Systems'), ['errorField' => 'system_id']);
        $rules->add($rules->existsIn(['item_id'], 'GroupItems'), ['errorField' => 'item_id']);

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

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerBomDetails Model
 *
 * @property \ProductBackend\Model\Table\CustomerBomsTable&\Cake\ORM\Association\BelongsTo $CustomerBoms
 * @property \ProductBackend\Model\Table\CustomerBomDetailAdditionalSkusTable&\Cake\ORM\Association\HasMany $CustomerBomDetailAdditionalSkus
 *
 * @method \ProductBackend\Model\Entity\CustomerBomDetail newEmptyEntity()
 * @method \ProductBackend\Model\Entity\CustomerBomDetail newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CustomerBomDetailsTable extends Table
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

        $this->setTable('customer_bom_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CustomerBoms', [
            'foreignKey' => 'customer_bom_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.CustomerBoms',
        ]);
        $this->hasMany('CustomerBomDetailAdditionalSkus', [
            'foreignKey' => 'customer_bom_detail_id',
            'className' => 'ProductBackend.CustomerBomDetailAdditionalSkus',
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
            ->requirePresence('sequence', 'create')
            ->notEmptyString('sequence');

        $validator
            ->requirePresence('option', 'create')
            ->notEmptyString('option');

        $validator
            ->scalar('sage_itemcode')
            ->maxLength('sage_itemcode', 30)
            ->requirePresence('sage_itemcode', 'create')
            ->notEmptyString('sage_itemcode');

        $validator
            ->allowEmptyString('quantity');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 2048)
            ->allowEmptyString('comment');

        $validator
            ->numeric('price')
            ->notEmptyString('price');

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
        $rules->add($rules->existsIn(['customer_bom_id'], 'CustomerBoms'), ['errorField' => 'customer_bom_id']);

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

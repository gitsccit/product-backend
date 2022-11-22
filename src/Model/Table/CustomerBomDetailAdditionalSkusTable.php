<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerBomDetailAdditionalSkus Model
 *
 * @property \ProductBackend\Model\Table\CustomerBomDetailsTable&\Cake\ORM\Association\BelongsTo $CustomerBomDetails
 *
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus newEmptyEntity()
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\CustomerBomDetailAdditionalSkus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CustomerBomDetailAdditionalSkusTable extends Table
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

        $this->setTable('customer_bom_detail_additional_skus');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CustomerBomDetails', [
            'foreignKey' => 'customer_bom_detail_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.CustomerBomDetails',
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
            ->nonNegativeInteger('customer_bom_detail_id')
            ->notEmptyString('customer_bom_detail_id');

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
        $rules->add($rules->existsIn('customer_bom_detail_id', 'CustomerBomDetails'), ['errorField' => 'customer_bom_detail_id']);

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

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KitOptionCodeItems Model
 *
 * @property \ProductBackend\Model\Table\KitOptionCodesTable&\Cake\ORM\Association\BelongsTo $KitOptionCodes
 * @property \ProductBackend\Model\Table\KitItemsTable&\Cake\ORM\Association\BelongsTo $KitItems
 *
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem newEmptyEntity()
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCodeItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class KitOptionCodeItemsTable extends Table
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

        $this->setTable('kit_option_code_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('KitOptionCodes', [
            'foreignKey' => 'kit_option_code_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.KitOptionCodes',
        ]);
        $this->belongsTo('KitItems', [
            'foreignKey' => 'kit_item_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.KitItems',
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
            ->nonNegativeInteger('kit_option_code_id')
            ->notEmptyString('kit_option_code_id');

        $validator
            ->nonNegativeInteger('kit_item_id')
            ->notEmptyString('kit_item_id');

        $validator
            ->requirePresence('position', 'create')
            ->notEmptyString('position');

        $validator
            ->scalar('part_number')
            ->maxLength('part_number', 20)
            ->allowEmptyString('part_number');

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
        $rules->add($rules->existsIn('kit_option_code_id', 'KitOptionCodes'), ['errorField' => 'kit_option_code_id']);
        $rules->add($rules->existsIn('kit_item_id', 'KitItems'), ['errorField' => 'kit_item_id']);

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

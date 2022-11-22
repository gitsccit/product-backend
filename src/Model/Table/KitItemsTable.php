<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KitItems Model
 *
 * @property \ProductBackend\Model\Table\KitsTable&\Cake\ORM\Association\BelongsTo $Kits
 * @property \ProductBackend\Model\Table\GroupItemsTable&\Cake\ORM\Association\BelongsTo $GroupItems
 * @property \ProductBackend\Model\Table\KitOptionCodeItemsTable&\Cake\ORM\Association\HasMany $KitOptionCodeItems
 *
 * @method \ProductBackend\Model\Entity\KitItem newEmptyEntity()
 * @method \ProductBackend\Model\Entity\KitItem newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitItem[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitItem get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\KitItem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\KitItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitItem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitItem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitItem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitItem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitItem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitItem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitItem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class KitItemsTable extends Table
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

        $this->setTable('kit_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Kits', [
            'foreignKey' => 'kit_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Kits',
        ]);
        $this->belongsTo('GroupItems', [
            'foreignKey' => 'group_item_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.GroupItems',
        ]);
        $this->hasMany('KitOptionCodeItems', [
            'foreignKey' => 'kit_item_id',
            'className' => 'ProductBackend.KitOptionCodeItems',
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
            ->nonNegativeInteger('kit_id')
            ->notEmptyString('kit_id');

        $validator
            ->nonNegativeInteger('group_item_id')
            ->notEmptyString('group_item_id');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

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
        $rules->add($rules->existsIn('kit_id', 'Kits'), ['errorField' => 'kit_id']);
        $rules->add($rules->existsIn('group_item_id', 'GroupItems'), ['errorField' => 'group_item_id']);

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

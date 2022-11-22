<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KitOptionCodes Model
 *
 * @property \ProductBackend\Model\Table\KitsTable&\Cake\ORM\Association\BelongsTo $Kits
 * @property \ProductBackend\Model\Table\KitOptionCodeItemsTable&\Cake\ORM\Association\HasMany $KitOptionCodeItems
 *
 * @method \ProductBackend\Model\Entity\KitOptionCode newEmptyEntity()
 * @method \ProductBackend\Model\Entity\KitOptionCode newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitOptionCode[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class KitOptionCodesTable extends Table
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

        $this->setTable('kit_option_codes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Kits', [
            'foreignKey' => 'kit_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Kits',
        ]);
        $this->hasMany('KitOptionCodeItems', [
            'foreignKey' => 'kit_option_code_id',
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
            ->scalar('part_number')
            ->maxLength('part_number', 50)
            ->requirePresence('part_number', 'create')
            ->notEmptyString('part_number');

        $validator
            ->requirePresence('positions', 'create')
            ->notEmptyString('positions');

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

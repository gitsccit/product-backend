<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PriceLevelPerspectives Model
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable&\Cake\ORM\Association\BelongsTo $Perspectives
 * @property \ProductBackend\Model\Table\PriceLevelsTable&\Cake\ORM\Association\BelongsTo $PriceLevels
 *
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective newEmptyEntity()
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevelPerspective[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PriceLevelPerspectivesTable extends Table
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

        $this->setTable('price_level_perspectives');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perspectives', [
            'foreignKey' => 'perspective_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Perspectives',
        ]);
        $this->belongsTo('PriceLevels', [
            'foreignKey' => 'price_level_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.PriceLevels',
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
            ->nonNegativeInteger('perspective_id')
            ->notEmptyString('perspective_id');

        $validator
            ->nonNegativeInteger('price_level_id')
            ->notEmptyString('price_level_id');

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
        $rules->add($rules->existsIn('perspective_id', 'Perspectives'), ['errorField' => 'perspective_id']);
        $rules->add($rules->existsIn('price_level_id', 'PriceLevels'), ['errorField' => 'price_level_id']);

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

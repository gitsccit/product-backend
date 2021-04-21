<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemPerspectives Model
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable&\Cake\ORM\Association\BelongsTo $Perspectives
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\BelongsTo $Systems
 *
 * @method \ProductBackend\Model\Entity\SystemPerspective newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SystemPerspective newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemPerspective[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemPerspectivesTable extends Table
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

        $this->setTable('system_perspectives');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perspectives', [
            'foreignKey' => 'perspective_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Perspectives',
        ]);
        $this->belongsTo('Systems', [
            'foreignKey' => 'system_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Systems',
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
            ->scalar('price_lock')
            ->allowEmptyString('price_lock');

        $validator
            ->scalar('url')
            ->maxLength('url', 80)
            ->allowEmptyString('url');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->allowEmptyString('name');

        $validator
            ->scalar('name_line_1')
            ->maxLength('name_line_1', 30)
            ->allowEmptyString('name_line_1');

        $validator
            ->scalar('name_line_2')
            ->maxLength('name_line_2', 50)
            ->allowEmptyString('name_line_2');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('meta_title')
            ->maxLength('meta_title', 90)
            ->allowEmptyString('meta_title');

        $validator
            ->scalar('meta_keywords')
            ->allowEmptyString('meta_keywords');

        $validator
            ->scalar('meta_description')
            ->allowEmptyString('meta_description');

        $validator
            ->scalar('category_browse')
            ->allowEmptyString('category_browse');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

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
        $rules->add($rules->existsIn(['perspective_id'], 'Perspectives'), ['errorField' => 'perspective_id']);
        $rules->add($rules->existsIn(['system_id'], 'Systems'), ['errorField' => 'system_id']);

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

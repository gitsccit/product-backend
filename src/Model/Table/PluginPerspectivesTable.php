<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PluginPerspectives Model
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable&\Cake\ORM\Association\BelongsTo $Perspectives
 * @property \ProductBackend\Model\Table\PluginsTable&\Cake\ORM\Association\BelongsTo $Plugins
 *
 * @method \ProductBackend\Model\Entity\PluginPerspective newEmptyEntity()
 * @method \ProductBackend\Model\Entity\PluginPerspective newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PluginPerspective[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PluginPerspectivesTable extends Table
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

        $this->setTable('plugin_perspectives');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perspectives', [
            'foreignKey' => 'perspective_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Perspectives',
        ]);
        $this->belongsTo('Plugins', [
            'foreignKey' => 'plugin_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Plugins',
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
            ->maxLength('name', 50)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

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
        $rules->add($rules->existsIn(['plugin_id'], 'Plugins'), ['errorField' => 'plugin_id']);

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

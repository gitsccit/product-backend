<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * KitsPlugins Model
 *
 * @property \ProductBackend\Model\Table\KitsTable&\Cake\ORM\Association\BelongsTo $Kits
 * @property \ProductBackend\Model\Table\PluginsTable&\Cake\ORM\Association\BelongsTo $Plugins
 *
 * @method \ProductBackend\Model\Entity\KitsPlugin newEmptyEntity()
 * @method \ProductBackend\Model\Entity\KitsPlugin newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\KitsPlugin[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class KitsPluginsTable extends Table
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

        $this->setTable('kits_plugins');

        $this->belongsTo('Kits', [
            'foreignKey' => 'kit_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Kits',
        ]);
        $this->belongsTo('Plugins', [
            'foreignKey' => 'plugin_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Plugins',
        ]);
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
        $rules->add($rules->existsIn(['kit_id'], 'Kits'), ['errorField' => 'kit_id']);
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

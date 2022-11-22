<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Plugins Model
 *
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\HasMany $Buckets
 * @property \ProductBackend\Model\Table\PluginPerspectivesTable&\Cake\ORM\Association\HasMany $PluginPerspectives
 * @property \ProductBackend\Model\Table\TabsTable&\Cake\ORM\Association\HasMany $Tabs
 * @property \ProductBackend\Model\Table\KitsTable&\Cake\ORM\Association\BelongsToMany $Kits
 *
 * @method \ProductBackend\Model\Entity\Plugin newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Plugin newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Plugin[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Plugin get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Plugin findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Plugin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Plugin[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Plugin|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Plugin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Plugin[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Plugin[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Plugin[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Plugin[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PluginsTable extends Table
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

        $this->setTable('plugins');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Buckets', [
            'foreignKey' => 'plugin_id',
            'className' => 'ProductBackend.Buckets',
        ]);
        $this->hasMany('PluginPerspectives', [
            'foreignKey' => 'plugin_id',
            'className' => 'ProductBackend.PluginPerspectives',
        ]);
        $this->hasMany('Tabs', [
            'foreignKey' => 'plugin_id',
            'className' => 'ProductBackend.Tabs',
        ]);
        $this->belongsToMany('Kits', [
            'foreignKey' => 'plugin_id',
            'targetForeignKey' => 'kit_id',
            'joinTable' => 'kits_plugins',
            'className' => 'ProductBackend.Kits',
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
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->scalar('include')
            ->maxLength('include', 250)
            ->allowEmptyString('include');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        return $validator;
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

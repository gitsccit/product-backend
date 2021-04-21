<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tabs Model
 *
 * @property \ProductBackend\Model\Table\FilesTable&\Cake\ORM\Association\BelongsTo $Files
 * @property \ProductBackend\Model\Table\PluginsTable&\Cake\ORM\Association\BelongsTo $Plugins
 * @property \ProductBackend\Model\Table\BucketCategoriesTable&\Cake\ORM\Association\HasMany $BucketCategories
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\HasMany $Buckets
 * @property \ProductBackend\Model\Table\TabPerspectivesTable&\Cake\ORM\Association\HasMany $TabPerspectives
 *
 * @method \ProductBackend\Model\Entity\Tab newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Tab newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Tab[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Tab get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Tab findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Tab patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Tab[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Tab|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Tab saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Tab[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Tab[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Tab[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Tab[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TabsTable extends Table
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

        $this->setTable('tabs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Files', [
            'foreignKey' => 'file_id',
            'className' => 'ProductBackend.Files',
        ]);
        $this->belongsTo('Plugins', [
            'foreignKey' => 'plugin_id',
            'className' => 'ProductBackend.Plugins',
        ]);
        $this->hasMany('BucketCategories', [
            'foreignKey' => 'tab_id',
            'className' => 'ProductBackend.BucketCategories',
        ]);
        $this->hasMany('Buckets', [
            'foreignKey' => 'tab_id',
            'className' => 'ProductBackend.Buckets',
        ]);
        $this->hasMany('TabPerspectives', [
            'foreignKey' => 'tab_id',
            'className' => 'ProductBackend.TabPerspectives',
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
            ->nonNegativeInteger('sort')
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
        $rules->add($rules->existsIn(['file_id'], 'Files'), ['errorField' => 'file_id']);
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

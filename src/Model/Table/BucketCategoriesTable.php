<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BucketCategories Model
 *
 * @property \ProductBackend\Model\Table\BucketCategoriesTable&\Cake\ORM\Association\BelongsTo $ParentBucketCategories
 * @property \ProductBackend\Model\Table\TabsTable&\Cake\ORM\Association\BelongsTo $Tabs
 * @property \ProductBackend\Model\Table\BucketCategoriesTable&\Cake\ORM\Association\HasMany $ChildBucketCategories
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\HasMany $Buckets
 * @method \ProductBackend\Model\Entity\BucketCategory newEmptyEntity()
 * @method \ProductBackend\Model\Entity\BucketCategory newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\BucketCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BucketCategoriesTable extends Table
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

        $this->setTable('bucket_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentBucketCategories', [
            'className' => 'ProductBackend.BucketCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('Tabs', [
            'foreignKey' => 'tab_id',
            'className' => 'ProductBackend.Tabs',
        ]);
        $this->hasMany('ChildBucketCategories', [
            'className' => 'ProductBackend.BucketCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('Buckets', [
            'foreignKey' => 'bucket_category_id',
            'className' => 'ProductBackend.Buckets',
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
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentBucketCategories'), ['errorField' => 'parent_id']);
        $rules->add($rules->existsIn(['tab_id'], 'Tabs'), ['errorField' => 'tab_id']);

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

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Collection\CollectionInterface;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\FactoryLocator;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Buckets Model
 *
 * @property \ProductBackend\Model\Table\BucketCategoriesTable&\Cake\ORM\Association\BelongsTo $BucketCategories
 * @property \ProductBackend\Model\Table\TabsTable&\Cake\ORM\Association\BelongsTo $Tabs
 * @property \ProductBackend\Model\Table\PluginsTable&\Cake\ORM\Association\BelongsTo $Plugins
 * @property \ProductBackend\Model\Table\KitBucketsTable&\Cake\ORM\Association\HasMany $KitBuckets
 * @property \ProductBackend\Model\Table\KitRuleDetailsTable&\Cake\ORM\Association\HasMany $KitRuleDetails
 * @property \ProductBackend\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsToMany $Groups
 *
 * @method \ProductBackend\Model\Entity\Bucket newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Bucket newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Bucket[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Bucket get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Bucket findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Bucket patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Bucket[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Bucket|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Bucket saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Bucket[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Bucket[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Bucket[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Bucket[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BucketsTable extends Table
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

        $this->setTable('buckets');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('BucketCategories', [
            'foreignKey' => 'bucket_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.BucketCategories',
        ]);
        $this->belongsTo('Tabs', [
            'foreignKey' => 'tab_id',
            'className' => 'ProductBackend.Tabs',
        ]);
        $this->belongsTo('Plugins', [
            'foreignKey' => 'plugin_id',
            'className' => 'ProductBackend.Plugins',
        ]);
        $this->hasMany('KitBuckets', [
            'foreignKey' => 'bucket_id',
            'className' => 'ProductBackend.KitBuckets',
        ]);
        $this->hasMany('KitRuleDetails', [
            'foreignKey' => 'bucket_id',
            'className' => 'ProductBackend.KitRuleDetails',
        ]);
        $this->belongsToMany('Kits', [
            'foreignKey' => 'bucket_id',
            'targetForeignKey' => 'kit_id',
            'joinTable' => 'kit_buckets',
            'className' => 'ProductBackend.Kits',
        ]);
        $this->belongsToMany('Groups', [
            'foreignKey' => 'bucket_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'buckets_groups',
            'className' => 'ProductBackend.Groups',
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
            ->nonNegativeInteger('bucket_category_id')
            ->notEmptyString('bucket_category_id');

        $validator
            ->nonNegativeInteger('tab_id')
            ->allowEmptyString('tab_id');

        $validator
            ->nonNegativeInteger('plugin_id')
            ->allowEmptyString('plugin_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 80)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('multiple')
            ->notEmptyString('multiple');

        $validator
            ->scalar('hidden')
            ->notEmptyString('hidden');

        $validator
            ->scalar('compare')
            ->notEmptyString('compare');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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
        $rules->add($rules->existsIn('bucket_category_id', 'BucketCategories'), ['errorField' => 'bucket_category_id']);
        $rules->add($rules->existsIn('tab_id', 'Tabs'), ['errorField' => 'tab_id']);
        $rules->add($rules->existsIn('plugin_id', 'Plugins'), ['errorField' => 'plugin_id']);

        return $rules;
    }

    public function findConfiguration(Query $query, mixed ...$options)
    {
        $kitID = $options['kitID'];
        ConnectionManager::get('product_backend')->getDriver()->enableAutoQuoting(true);

        return $query
            ->select([
                'Buckets.id',
                'Buckets.tab_id',
                'Buckets.name',
                'category' => 'BucketCategories.name',
                'Buckets.multiple',
                'Buckets.hidden',
                'Buckets.compare',
                'quantity' => 'KitBuckets.quantity',
                'minqty' => 'KitBuckets.minqty',
                'maxqty' => 'KitBuckets.maxqty',
                'notes' => 'CONCAT(KitBuckets.notes, Buckets.notes)',
            ])
            ->innerJoinWith('Kits')
            ->innerJoinWith('BucketCategories')
            ->contain('Groups', function (Query $q) use ($options, $kitID) {
                return $q
                    ->contain('GroupItems', function (Query $q) use ($options, $kitID) {
                        return $q->find('configuration', ...$options)->find('activeInKit', kitID: $kitID);
                    })
                    ->orderBy([
                        'Groups.sort',
                    ]);
            })
            ->where(['Kits.id' => $kitID])
            ->orderBy([
                'BucketCategories.sort',
                'BucketCategories.name',
            ])
            ->formatResults(function (CollectionInterface $result) {
                return $result->map(function ($bucket) {
                    $bucket->multiple = $bucket->multiple === 'yes';
                    $bucket->hidden = $bucket->hidden === 'yes';
                    $bucket->compare = $bucket->compare === 'yes';

                    // converts qty range to an array of available quantities
                    // quantities may be comma-separated or dash notation (1-5 is the same as 1,2,3,4,5 is the same as 1,2,3-5)
                    $quantities = [];
                    foreach (explode(',', $bucket->quantity) as $quantity) {
                        if (is_numeric($quantity)) {
                            $quantities[] = $quantity;
                            continue;
                        }

                        [$min, $max] = explode('-', $quantity);
                        $quantities = array_merge($quantities, range($min, $max));
                    }
                    $bucket->quantity = $quantities;

                    return $bucket;
                });
            });
    }

    public function findFilters(Query $query, mixed ...$options)
    {
        return $query
            ->formatResults(function (CollectionInterface $result) {
                return $result->map(function ($bucket) {
                    $filters = FactoryLocator::get('Table')->get('ProductBackend.Specifications')
                        ->find('specifications')
                        ->whereInList(
                            'product_id',
                            Hash::extract($bucket, 'groups.{n}.group_items.{n}.original_id')
                        )
                        ->all()
                        ->groupBy('name')
                        ->toArray();

                    foreach ($filters as $name => $filter) {
                        $parsedFilter = ['All'];
                        foreach ($filter as $spec) {
                            if (!in_array($spec['value'], $parsedFilter)) {
                                $parsedFilter[] = $spec['value'];
                            }
                        }
                        $filters[$name] = $parsedFilter;
                    }

                    $usefulFilters = array_filter($filters, function ($filter) {
                        return count($filter) > 2;
                    });
                    $placeholderFilters = array_filter($filters, function ($filter) {
                        return count($filter) <= 2;
                    });
                    $bucket->filters = array_merge($usefulFilters, $placeholderFilters);

                    return $bucket;
                });
            });
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

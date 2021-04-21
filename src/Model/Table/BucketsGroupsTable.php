<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * BucketsGroups Model
 *
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\BelongsTo $Buckets
 * @property \ProductBackend\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \ProductBackend\Model\Entity\BucketsGroup newEmptyEntity()
 * @method \ProductBackend\Model\Entity\BucketsGroup newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\BucketsGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BucketsGroupsTable extends Table
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

        $this->setTable('buckets_groups');

        $this->belongsTo('Buckets', [
            'foreignKey' => 'bucket_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Buckets',
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Groups',
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
        $rules->add($rules->existsIn(['bucket_id'], 'Buckets'), ['errorField' => 'bucket_id']);
        $rules->add($rules->existsIn(['group_id'], 'Groups'), ['errorField' => 'group_id']);

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

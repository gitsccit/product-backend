<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 * @property \ProductBackend\Model\Table\GroupItemsTable&\Cake\ORM\Association\HasMany $GroupItems
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsToMany $Products
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\BelongsToMany $Systems
 * @property \ProductBackend\Model\Table\BucketsTable&\Cake\ORM\Association\BelongsToMany $Buckets
 *
 * @method \ProductBackend\Model\Entity\Group newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Group newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Group[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Group get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Group findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Group patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Group[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Group|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Group saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class GroupsTable extends Table
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

        $this->setTable('groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('GroupItems', [
            'foreignKey' => 'group_id',
            'className' => 'ProductBackend.GroupItems',
        ]);
        $this->belongsToMany('Products', [
            'through' => 'ProductBackend.GroupItems',
        ]);
        $this->belongsToMany('Systems', [
            'through' => 'ProductBackend.GroupItems',
        ]);
        $this->belongsToMany('Buckets', [
            'foreignKey' => 'group_id',
            'targetForeignKey' => 'bucket_id',
            'joinTable' => 'buckets_groups',
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
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('method')
            ->notEmptyString('method');

        $validator
            ->nonNegativeInteger('sort')
            ->notEmptyString('sort');

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

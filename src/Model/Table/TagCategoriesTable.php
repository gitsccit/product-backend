<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TagCategories Model
 *
 * @property \ProductBackend\Model\Table\TagsTable&\Cake\ORM\Association\HasMany $Tags
 * @method \ProductBackend\Model\Entity\TagCategory newEmptyEntity()
 * @method \ProductBackend\Model\Entity\TagCategory newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TagCategoriesTable extends Table
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

        $this->setTable('tag_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Tags', [
            'foreignKey' => 'tag_category_id',
            'className' => 'ProductBackend.Tags',
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
            ->scalar('filter')
            ->notEmptyString('filter');

        $validator
            ->nonNegativeInteger('filter_sequence')
            ->allowEmptyString('filter_sequence');

        $validator
            ->scalar('support')
            ->notEmptyString('support');

        $validator
            ->scalar('support_text')
            ->notEmptyString('support_text');

        $validator
            ->nonNegativeInteger('support_sequence')
            ->allowEmptyString('support_sequence');

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

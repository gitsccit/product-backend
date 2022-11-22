<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TagGroups Model
 *
 * @property \ProductBackend\Model\Table\TagsTable&\Cake\ORM\Association\HasMany $Tags
 * @property \ProductBackend\Model\Table\TagCategoriesTable&\Cake\ORM\Association\BelongsToMany $TagCategories
 *
 * @method \ProductBackend\Model\Entity\TagGroup newEmptyEntity()
 * @method \ProductBackend\Model\Entity\TagGroup newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TagGroupsTable extends Table
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

        $this->setTable('tag_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Tags', [
            'foreignKey' => 'tag_group_id',
            'className' => 'ProductBackend.Tags',
        ]);
        $this->belongsToMany('TagCategories', [
            'foreignKey' => 'tag_group_id',
            'targetForeignKey' => 'tag_category_id',
            'joinTable' => 'tag_categories_tag_groups',
            'className' => 'ProductBackend.TagCategories',
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
            ->scalar('display_value')
            ->notEmptyString('display_value');

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

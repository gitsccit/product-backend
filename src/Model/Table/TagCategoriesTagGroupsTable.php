<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TagCategoriesTagGroups Model
 *
 * @property \ProductBackend\Model\Table\TagCategoriesTable&\Cake\ORM\Association\BelongsTo $TagCategories
 * @property \ProductBackend\Model\Table\TagGroupsTable&\Cake\ORM\Association\BelongsTo $TagGroups
 *
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup newEmptyEntity()
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TagCategoriesTagGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TagCategoriesTagGroupsTable extends Table
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

        $this->setTable('tag_categories_tag_groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TagCategories', [
            'foreignKey' => 'tag_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.TagCategories',
        ]);
        $this->belongsTo('TagGroups', [
            'foreignKey' => 'tag_group_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.TagGroups',
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
            ->nonNegativeInteger('tag_category_id')
            ->notEmptyString('tag_category_id');

        $validator
            ->nonNegativeInteger('tag_group_id')
            ->notEmptyString('tag_group_id');

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
        $rules->add($rules->existsIn('tag_category_id', 'TagCategories'), ['errorField' => 'tag_category_id']);
        $rules->add($rules->existsIn('tag_group_id', 'TagGroups'), ['errorField' => 'tag_group_id']);

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

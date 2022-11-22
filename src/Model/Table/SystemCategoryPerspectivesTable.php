<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemCategoryPerspectives Model
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable&\Cake\ORM\Association\BelongsTo $Perspectives
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\BelongsTo $SystemCategories
 * @property \ProductBackend\Model\Table\BannersTable&\Cake\ORM\Association\BelongsTo $Banners
 *
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategoryPerspective[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemCategoryPerspectivesTable extends Table
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

        $this->setTable('system_category_perspectives');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perspectives', [
            'foreignKey' => 'perspective_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Perspectives',
        ]);
        $this->belongsTo('SystemCategories', [
            'foreignKey' => 'system_category_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.SystemCategories',
        ]);
        $this->belongsTo('Banners', [
            'foreignKey' => 'banner_id',
            'className' => 'ProductBackend.Banners',
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
            ->nonNegativeInteger('perspective_id')
            ->notEmptyString('perspective_id');

        $validator
            ->nonNegativeInteger('system_category_id')
            ->notEmptyString('system_category_id');

        $validator
            ->scalar('url')
            ->maxLength('url', 80)
            ->allowEmptyString('url');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->nonNegativeInteger('banner_id')
            ->allowEmptyString('banner_id');

        $validator
            ->scalar('active')
            ->allowEmptyString('active');

        $validator
            ->nonNegativeInteger('children')
            ->allowEmptyString('children');

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
        $rules->add($rules->existsIn('perspective_id', 'Perspectives'), ['errorField' => 'perspective_id']);
        $rules->add($rules->existsIn('system_category_id', 'SystemCategories'), ['errorField' => 'system_category_id']);
        $rules->add($rules->existsIn('banner_id', 'Banners'), ['errorField' => 'banner_id']);

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

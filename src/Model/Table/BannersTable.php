<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Banners Model
 *
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\HasMany $SystemCategories
 * @property \ProductBackend\Model\Table\SystemCategoryPerspectivesTable&\Cake\ORM\Association\HasMany $SystemCategoryPerspectives
 *
 * @method \ProductBackend\Model\Entity\Banner newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Banner newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Banner[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Banner get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Banner findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Banner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Banner[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Banner|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Banner saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BannersTable extends Table
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

        $this->setTable('banners');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('SystemCategories', [
            'foreignKey' => 'banner_id',
            'className' => 'ProductBackend.SystemCategories',
        ]);
        $this->hasMany('SystemCategoryPerspectives', [
            'foreignKey' => 'banner_id',
            'className' => 'ProductBackend.SystemCategoryPerspectives',
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
            ->nonNegativeInteger('image_id')
            ->allowEmptyFile('image_id');

        $validator
            ->nonNegativeInteger('tile_id')
            ->allowEmptyString('tile_id');

        $validator
            ->scalar('horizontal')
            ->notEmptyString('horizontal');

        $validator
            ->scalar('vertical')
            ->notEmptyString('vertical');

        $validator
            ->scalar('style')
            ->notEmptyString('style');

        $validator
            ->nonNegativeInteger('sort')
            ->notEmptyString('sort');

        $validator
            ->dateTime('timestamp')
            ->notEmptyDateTime('timestamp');

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

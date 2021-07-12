<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Banners Model
 *
 * @property \ProductBackend\Model\Table\ImagesTable&\Cake\ORM\Association\BelongsTo $Images
 * @property \ProductBackend\Model\Table\TilesTable&\Cake\ORM\Association\BelongsTo $Tiles
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\HasMany $SystemCategories
 * @property \ProductBackend\Model\Table\SystemCategoryPerspectivesTable&\Cake\ORM\Association\HasMany $SystemCategoryPerspectives
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

        $this->belongsTo('Images', [
            'foreignKey' => 'image_id',
            'className' => 'ProductBackend.Images',
        ]);
        $this->belongsTo('Tiles', [
            'foreignKey' => 'tile_id',
            'className' => 'ProductBackend.Tiles',
        ]);
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['image_id'], 'Images'), ['errorField' => 'image_id']);
        $rules->add($rules->existsIn(['tile_id'], 'Tiles'), ['errorField' => 'tile_id']);

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

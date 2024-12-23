<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Http\Session;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * SystemCategories Model
 *
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\BelongsTo $ParentSystemCategories
 * @property \ProductBackend\Model\Table\BannersTable&\Cake\ORM\Association\BelongsTo $Banners
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\HasMany $ChildSystemCategories
 * @property \ProductBackend\Model\Table\SystemCategoryPerspectivesTable&\Cake\ORM\Association\HasMany $SystemCategoryPerspectives
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\HasMany $Systems
 *
 * @method \ProductBackend\Model\Entity\SystemCategory newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SystemCategory newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SystemCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SystemCategoriesTable extends Table
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

        $this->setTable('system_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentSystemCategories', [
            'className' => 'ProductBackend.SystemCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('PriceLevels', [
            'foreignKey' => 'price_level_id',
            'className' => 'ProductBackend.PriceLevels',
        ]);
        $this->belongsTo('Banners', [
            'foreignKey' => 'banner_id',
            'className' => 'ProductBackend.Banners',
        ]);
        $this->hasMany('ChildSystemCategories', [
            'className' => 'ProductBackend.SystemCategories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('SystemCategoryPerspectives', [
            'foreignKey' => 'system_category_id',
            'className' => 'ProductBackend.SystemCategoryPerspectives',
        ]);
        $this->hasMany('Systems', [
            'foreignKey' => 'system_category_id',
            'className' => 'ProductBackend.Systems',
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
            ->nonNegativeInteger('parent_id')
            ->allowEmptyString('parent_id');

        $validator
            ->scalar('url')
            ->maxLength('url', 80)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->scalar('name')
            ->maxLength('name', 80)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('short_description')
            ->maxLength('short_description', 50)
            ->requirePresence('short_description', 'create')
            ->notEmptyString('short_description');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('classification')
            ->maxLength('classification', 50)
            ->requirePresence('classification', 'create')
            ->notEmptyString('classification');

        $validator
            ->nonNegativeInteger('price_level_id')
            ->allowEmptyString('price_level_id');

        $validator
            ->nonNegativeInteger('force_perspective')
            ->allowEmptyString('force_perspective');

        $validator
            ->nonNegativeInteger('banner_id')
            ->allowEmptyString('banner_id');

        $validator
            ->scalar('spares_kits')
            ->notEmptyString('spares_kits');

        $validator
            ->scalar('active')
            ->notEmptyString('active');

        $validator
            ->nonNegativeInteger('children')
            ->notEmptyString('children');

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
        $rules->add($rules->existsIn('parent_id', 'ParentSystemCategories'), ['errorField' => 'parent_id']);
        $rules->add($rules->existsIn('price_level_id', 'PriceLevels'), ['errorField' => 'price_level_id']);
        $rules->add($rules->existsIn('banner_id', 'Banners'), ['errorField' => 'banner_id']);

        return $rules;
    }

    public function findListing(Query $query, mixed ...$options)
    {
        $session = new Session();
        $perspectiveID = $options['perspective'] ?? $session->read('store.perspective');

        return $this->find()
            ->select([
                'SystemCategories.id',
                'SystemCategories.parent_id',
                'url' => 'IFNULL(SystemCategoryPerspectives.url, SystemCategories.url)',
                'name' => 'IFNULL(SystemCategoryPerspectives.name, SystemCategories.name)',
                'SystemCategories.classification',
                'SystemCategories.description',
                'SystemCategories.short_description',
                'product_count' => 'IFNULL(SystemCategoryPerspectives.children, SystemCategories.children)',
                'image_id' => $this->Systems->find('image', fetchUrl: false)
                    ->where(['Systems.system_category_id = SystemCategories.id'])
                    ->limit(1),
            ])
            ->leftJoinWith('SystemCategoryPerspectives', function (Query $query) use ($perspectiveID) {
                return $query->where([
                    'SystemCategoryPerspectives.perspective_id' => $perspectiveID,
                ]);
            })
            ->where([
                'IFNULL(SystemCategoryPerspectives.active, SystemCategories.active) =' => 'yes',
                'IFNULL(SystemCategoryPerspectives.children, SystemCategories.children) >' => 0,
            ])
            ->orderByAsc('SystemCategories.sort')
            ->formatResults(function (ResultSet $result) {
                $filesApiHandler = new \FilesApiHandler();
                $imageIDs = array_unique($result->extract('image_id')->toList());
                $images = $filesApiHandler->getFileUrls($imageIDs, 400, 400);

                foreach ($result as $systemCategory) {
                    $systemCategory['image'] = $images[$systemCategory['image_id']] ?? null;
                }

                $resultNested = $result->nest('id', 'parent_id')->indexBy('id')->toArray();
                foreach ($result as $systemCategory) {
                    if (!isset($systemCategory['image'])) {
                        $systemCategory['image'] = $resultNested[$systemCategory['id']]['children'][0]['image'] ?? null;
                    }
                }

                return $result;
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

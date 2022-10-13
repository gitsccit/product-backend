<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\Http\Session;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SystemCategories Model
 *
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\BelongsTo $ParentSystemCategories
 * @property \ProductBackend\Model\Table\BannersTable&\Cake\ORM\Association\BelongsTo $Banners
 * @property \ProductBackend\Model\Table\SystemCategoriesTable&\Cake\ORM\Association\HasMany $ChildSystemCategories
 * @property \ProductBackend\Model\Table\SystemCategoryPerspectivesTable&\Cake\ORM\Association\HasMany $SystemCategoryPerspectives
 * @property \ProductBackend\Model\Table\SystemsTable&\Cake\ORM\Association\HasMany $Systems
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

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
            ->scalar('description')
            ->maxLength('description', 250)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->nonNegativeInteger('force_perspective')
            ->allowEmptyString('force_perspective');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentSystemCategories'), ['errorField' => 'parent_id']);
        $rules->add($rules->existsIn(['banner_id'], 'Banners'), ['errorField' => 'banner_id']);

        return $rules;
    }

    public function findListing(Query $query, $options)
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
            ->orderAsc('SystemCategories.sort')
            ->formatResults(function (ResultSet $result) {
                $systemCategories = $result->extract('id')->toList();
                $systems = $this->Systems
                    ->find('active')
                    ->find('image')
                    ->distinct('system_category_id')
                    ->whereInList('system_category_id', $systemCategories)
                    ->all()
                    ->indexBy('system_category_id')
                    ->toArray();

                foreach ($result as $systemCategory) {
                    $systemCategory['image'] = $systems[$systemCategory['id']]['image'] ?? null;
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

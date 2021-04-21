<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Perspectives Model
 *
 * @property \ProductBackend\Model\Table\CustomersTable&\Cake\ORM\Association\HasMany $Customers
 * @property \ProductBackend\Model\Table\PluginPerspectivesTable&\Cake\ORM\Association\HasMany $PluginPerspectives
 * @property \ProductBackend\Model\Table\PriceLevelPerspectivesTable&\Cake\ORM\Association\HasMany $PriceLevelPerspectives
 * @property \ProductBackend\Model\Table\ProductCategoryPerspectivesTable&\Cake\ORM\Association\HasMany $ProductCategoryPerspectives
 * @property \ProductBackend\Model\Table\ProductPerspectivesTable&\Cake\ORM\Association\HasMany $ProductPerspectives
 * @property \ProductBackend\Model\Table\SystemCategoryPerspectivesTable&\Cake\ORM\Association\HasMany $SystemCategoryPerspectives
 * @property \ProductBackend\Model\Table\SystemPerspectivesTable&\Cake\ORM\Association\HasMany $SystemPerspectives
 * @property \ProductBackend\Model\Table\TabPerspectivesTable&\Cake\ORM\Association\HasMany $TabPerspectives
 *
 * @method \ProductBackend\Model\Entity\Perspective newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Perspective newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Perspective[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Perspective get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Perspective findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Perspective patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Perspective[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Perspective|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Perspective saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Perspective[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Perspective[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Perspective[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Perspective[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PerspectivesTable extends Table
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

        $this->setTable('perspectives');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Customers', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.Customers',
        ]);
        $this->hasMany('PluginPerspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.PluginPerspectives',
        ]);
        $this->hasMany('PriceLevelPerspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.PriceLevelPerspectives',
        ]);
        $this->hasMany('ProductCategoryPerspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.ProductCategoryPerspectives',
        ]);
        $this->hasMany('ProductPerspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.ProductPerspectives',
        ]);
        $this->hasMany('SystemCategoryPerspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.SystemCategoryPerspectives',
        ]);
        $this->hasMany('SystemPerspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.SystemPerspectives',
        ]);
        $this->hasMany('TabPerspectives', [
            'foreignKey' => 'perspective_id',
            'className' => 'ProductBackend.TabPerspectives',
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
            ->scalar('active')
            ->notEmptyString('active');

        $validator
            ->scalar('type')
            ->notEmptyString('type');

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

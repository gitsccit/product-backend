<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PriceLevels Model
 *
 * @property \ProductBackend\Model\Table\PriceLevelPerspectivesTable&\Cake\ORM\Association\HasMany $PriceLevelPerspectives
 * @property \ProductBackend\Model\Table\ProductPriceLevelsTable&\Cake\ORM\Association\HasMany $ProductPriceLevels
 * @property \ProductBackend\Model\Table\SystemPriceLevelsTable&\Cake\ORM\Association\HasMany $SystemPriceLevels
 *
 * @method \ProductBackend\Model\Entity\PriceLevel newEmptyEntity()
 * @method \ProductBackend\Model\Entity\PriceLevel newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\PriceLevel[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PriceLevelsTable extends Table
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

        $this->setTable('price_levels');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('PriceLevelPerspectives', [
            'foreignKey' => 'price_level_id',
            'className' => 'ProductBackend.PriceLevelPerspectives',
        ]);
        $this->hasMany('ProductPriceLevels', [
            'foreignKey' => 'price_level_id',
            'className' => 'ProductBackend.ProductPriceLevels',
        ]);
        $this->hasMany('SystemPriceLevels', [
            'foreignKey' => 'price_level_id',
            'className' => 'ProductBackend.SystemPriceLevels',
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
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->nonNegativeInteger('markup')
            ->requirePresence('markup', 'create')
            ->notEmptyString('markup');

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

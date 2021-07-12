<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpareCategories Model
 *
 * @property \ProductBackend\Model\Table\SpareCategoryRelationsTable&\Cake\ORM\Association\HasMany $SpareCategoryRelations
 * @property \ProductBackend\Model\Table\SparesTable&\Cake\ORM\Association\HasMany $Spares
 * @method \ProductBackend\Model\Entity\SpareCategory newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SpareCategory newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SpareCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SpareCategoriesTable extends Table
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

        $this->setTable('spare_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('SpareCategoryRelations', [
            'foreignKey' => 'spare_category_id',
            'className' => 'ProductBackend.SpareCategoryRelations',
        ]);
        $this->hasMany('Spares', [
            'foreignKey' => 'spare_category_id',
            'className' => 'ProductBackend.Spares',
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->notEmptyString('quantity');

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

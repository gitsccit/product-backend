<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductStatuses Model
 *
 * @method \ProductBackend\Model\Entity\ProductStatus newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ProductStatus newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ProductStatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProductStatusesTable extends Table
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

        $this->setTable('product_statuses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->allowEmptyString('name');

        $validator
            ->scalar('warning')
            ->allowEmptyString('warning');

        $validator
            ->scalar('sowg')
            ->allowEmptyString('sowg');

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

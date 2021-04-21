<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActiveBackendDatabase Model
 *
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase newEmptyEntity()
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\ActiveBackendDatabase[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ActiveBackendDatabaseTable extends Table
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

        $this->setTable('active_backend_database');
        $this->setDisplayField('name');
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

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabPerspectives Model
 *
 * @property \ProductBackend\Model\Table\PerspectivesTable&\Cake\ORM\Association\BelongsTo $Perspectives
 * @property \ProductBackend\Model\Table\TabsTable&\Cake\ORM\Association\BelongsTo $Tabs
 * @property \ProductBackend\Model\Table\FilesTable&\Cake\ORM\Association\BelongsTo $Files
 *
 * @method \ProductBackend\Model\Entity\TabPerspective newEmptyEntity()
 * @method \ProductBackend\Model\Entity\TabPerspective newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\TabPerspective[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TabPerspectivesTable extends Table
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

        $this->setTable('tab_perspectives');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perspectives', [
            'foreignKey' => 'perspective_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Perspectives',
        ]);
        $this->belongsTo('Tabs', [
            'foreignKey' => 'tab_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Tabs',
        ]);
        $this->belongsTo('Files', [
            'foreignKey' => 'file_id',
            'className' => 'ProductBackend.Files',
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
            ->nonNegativeInteger('tab_id')
            ->notEmptyString('tab_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->nonNegativeInteger('file_id')
            ->allowEmptyFile('file_id');

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
        $rules->add($rules->existsIn('tab_id', 'Tabs'), ['errorField' => 'tab_id']);
        $rules->add($rules->existsIn('file_id', 'Files'), ['errorField' => 'file_id']);

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

<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SkuRulesFiles Model
 *
 * @property \ProductBackend\Model\Table\SkuRulesTable&\Cake\ORM\Association\BelongsTo $SkuRules
 * @property \ProductBackend\Model\Table\FilesTable&\Cake\ORM\Association\BelongsTo $Files
 *
 * @method \ProductBackend\Model\Entity\SkuRulesFile newEmptyEntity()
 * @method \ProductBackend\Model\Entity\SkuRulesFile newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\SkuRulesFile[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SkuRulesFilesTable extends Table
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

        $this->setTable('sku_rules_files');

        $this->belongsTo('SkuRules', [
            'foreignKey' => 'sku_rule_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.SkuRules',
        ]);
        $this->belongsTo('Files', [
            'foreignKey' => 'file_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('sku_rule_id')
            ->notEmptyString('sku_rule_id');

        $validator
            ->nonNegativeInteger('file_id')
            ->notEmptyFile('file_id');

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
        $rules->add($rules->existsIn('sku_rule_id', 'SkuRules'), ['errorField' => 'sku_rule_id']);
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

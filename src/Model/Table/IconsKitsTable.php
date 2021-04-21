<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * IconsKits Model
 *
 * @property \ProductBackend\Model\Table\IconsTable&\Cake\ORM\Association\BelongsTo $Icons
 * @property \ProductBackend\Model\Table\KitsTable&\Cake\ORM\Association\BelongsTo $Kits
 *
 * @method \ProductBackend\Model\Entity\IconsKit newEmptyEntity()
 * @method \ProductBackend\Model\Entity\IconsKit newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\IconsKit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class IconsKitsTable extends Table
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

        $this->setTable('icons_kits');

        $this->belongsTo('Icons', [
            'foreignKey' => 'icon_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Icons',
        ]);
        $this->belongsTo('Kits', [
            'foreignKey' => 'kit_id',
            'joinType' => 'INNER',
            'className' => 'ProductBackend.Kits',
        ]);
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
        $rules->add($rules->existsIn(['icon_id'], 'Icons'), ['errorField' => 'icon_id']);
        $rules->add($rules->existsIn(['kit_id'], 'Kits'), ['errorField' => 'kit_id']);

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

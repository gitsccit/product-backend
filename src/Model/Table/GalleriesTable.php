<?php
declare(strict_types=1);

namespace ProductBackend\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Galleries Model
 *
 * @property \ProductBackend\Model\Table\GalleryImagesTable&\Cake\ORM\Association\BelongsTo $ProductGalleryImages
 * @property \ProductBackend\Model\Table\GalleryImagesTable&\Cake\ORM\Association\BelongsTo $BrowseGalleryImages
 * @property \ProductBackend\Model\Table\GalleryImagesTable&\Cake\ORM\Association\BelongsTo $SystemGalleryImages
 * @property \ProductBackend\Model\Table\GalleryImagesTable&\Cake\ORM\Association\HasMany $GalleryImages
 * @property \ProductBackend\Model\Table\ProductsTable&\Cake\ORM\Association\HasMany $Products
 *
 * @method \ProductBackend\Model\Entity\Gallery newEmptyEntity()
 * @method \ProductBackend\Model\Entity\Gallery newEntity(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Gallery[] newEntities(array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Gallery get($primaryKey, $options = [])
 * @method \ProductBackend\Model\Entity\Gallery findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \ProductBackend\Model\Entity\Gallery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Gallery[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \ProductBackend\Model\Entity\Gallery|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Gallery saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ProductBackend\Model\Entity\Gallery[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Gallery[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Gallery[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \ProductBackend\Model\Entity\Gallery[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class GalleriesTable extends Table
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

        $this->setTable('galleries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductGalleryImages', [
            'foreignKey' => 'product_gallery_image_id',
            'className' => 'ProductBackend.GalleryImages',
        ]);
        $this->belongsTo('BrowseGalleryImages', [
            'foreignKey' => 'browse_gallery_image_id',
            'className' => 'ProductBackend.GalleryImages',
        ]);
        $this->belongsTo('SystemGalleryImages', [
            'foreignKey' => 'system_gallery_image_id',
            'className' => 'ProductBackend.GalleryImages',
        ]);
        $this->hasMany('GalleryImages', [
            'foreignKey' => 'gallery_id',
            'className' => 'ProductBackend.GalleryImages',
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'gallery_id',
            'className' => 'ProductBackend.Products',
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
            ->maxLength('name', 120)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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
        $rules->add($rules->existsIn(['product_gallery_image_id'], 'ProductGalleryImages'),
            ['errorField' => 'product_gallery_image_id']);
        $rules->add($rules->existsIn(['browse_gallery_image_id'], 'BrowseGalleryImages'),
            ['errorField' => 'browse_gallery_image_id']);
        $rules->add($rules->existsIn(['system_gallery_image_id'], 'SystemGalleryImages'),
            ['errorField' => 'system_gallery_image_id']);

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

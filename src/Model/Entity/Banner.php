<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Banner Entity
 *
 * @property int $id
 * @property int|null $image_id
 * @property int|null $tile_id
 * @property string $horizontal
 * @property string $vertical
 * @property string $style
 * @property int $sort
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\SystemCategory[] $system_categories
 * @property \ProductBackend\Model\Entity\SystemCategoryPerspective[] $system_category_perspectives
 */
class Banner extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'image_id' => true,
        'tile_id' => true,
        'horizontal' => true,
        'vertical' => true,
        'style' => true,
        'sort' => true,
        'timestamp' => true,
        'system_categories' => true,
        'system_category_perspectives' => true,
    ];
}

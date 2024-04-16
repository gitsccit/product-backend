<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * SkuRulesFile Entity
 *
 * @property int $sku_rule_id
 * @property int $file_id
 *
 * @property \ProductBackend\Model\Entity\SkuRule $sku_rule
 * @property \ProductBackend\Model\Entity\File $file
 */
class SkuRulesFile extends Entity
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
    protected array $_accessible = [
        'sku_rule_id' => true,
        'file_id' => true,
        'sku_rule' => true,
        'file' => true,
    ];
}

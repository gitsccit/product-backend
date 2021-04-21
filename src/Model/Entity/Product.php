<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\Datasource\FactoryLocator;
use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $url
 * @property string $name
 * @property string|null $description
 * @property int|null $product_category_id
 * @property int|null $gallery_id
 * @property int|null $manufacturer_id
 * @property string $part_number
 * @property string|null $sage_itemcode
 * @property string|null $upc
 * @property int|null $status_id
 * @property string|null $status_text
 * @property string|null $tax
 * @property float $cost
 * @property string $cost_maintenance
 * @property string $generic
 * @property bool|null $noise_level
 * @property string $generic_relations
 * @property int|null $kit_price_percent
 * @property string|null $show_related_systems
 * @property int|null $ship_box_id
 * @property string $ship_type
 * @property float $weight
 * @property float|null $length
 * @property float|null $width
 * @property float|null $height
 * @property int|null $country_of_origin_id
 * @property int|null $ship_from_id
 * @property string $lithium_battery
 * @property float|null $watts
 * @property int $system_use
 * @property int $system_start
 * @property string $active
 * @property int $sort
 * @property \Cake\I18n\FrozenDate|null $date_eol
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\ProductCategory $product_category
 * @property \ProductBackend\Model\Entity\Gallery $gallery
 * @property \ProductBackend\Model\Entity\Manufacturer $manufacturer
 * @property \ProductBackend\Model\Entity\ProductStatus $product_status
 * @property \ProductBackend\Model\Entity\ShipBox $ship_box
 * @property \ProductBackend\Model\Entity\Location $location
 * @property \ProductBackend\Model\Entity\CustomerProduct[] $customer_products
 * @property \ProductBackend\Model\Entity\Generic[] $generics
 * @property \ProductBackend\Model\Entity\GroupItem[] $group_items
 * @property \ProductBackend\Model\Entity\ProductAdditionalSkus[] $product_additional_skus
 * @property \ProductBackend\Model\Entity\ProductPerspective[] $product_perspectives
 * @property \ProductBackend\Model\Entity\ProductPriceLevel[] $product_price_levels
 * @property \ProductBackend\Model\Entity\ProductRule[] $product_rules
 * @property \ProductBackend\Model\Entity\ProductsRelation[] $products_relations
 * @property \ProductBackend\Model\Entity\Spare[] $spares
 * @property \ProductBackend\Model\Entity\Specification[] $specifications
 */
class Product extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'url' => true,
        'name' => true,
        'description' => true,
        'product_category_id' => true,
        'gallery_id' => true,
        'manufacturer_id' => true,
        'part_number' => true,
        'sage_itemcode' => true,
        'upc' => true,
        'status_id' => true,
        'status_text' => true,
        'tax' => true,
        'cost' => true,
        'cost_maintenance' => true,
        'generic' => true,
        'noise_level' => true,
        'generic_relations' => true,
        'kit_price_percent' => true,
        'show_related_systems' => true,
        'ship_box_id' => true,
        'ship_type' => true,
        'weight' => true,
        'length' => true,
        'width' => true,
        'height' => true,
        'country_of_origin_id' => true,
        'ship_from_id' => true,
        'lithium_battery' => true,
        'watts' => true,
        'system_use' => true,
        'system_start' => true,
        'active' => true,
        'sort' => true,
        'date_eol' => true,
        'date_added' => true,
        'timestamp' => true,
        'product_category' => true,
        'gallery' => true,
        'manufacturer' => true,
        'product_status' => true,
        'ship_box' => true,
        'location' => true,
        'customer_products' => true,
        'generics' => true,
        'group_items' => true,
        'product_additional_skus' => true,
        'product_perspectives' => true,
        'product_price_levels' => true,
        'product_rules' => true,
        'products_relations' => true,
        'spares' => true,
        'specifications' => true,
    ];

    public function getBreadcrumbs()
    {
        if (!isset($this->product_category)) {
            $this->product_category = FactoryLocator::get('Table')->get('ProductBackend.ProductCategories')
                ->get($this->product_category_id);
        }

        $breadcrumbs = $this->product_category->getBreadcrumbs();
        $breadcrumbs[] = [
            'title' => $this->part_number,
            'url' => "/product/$this->url",
        ];

        return $breadcrumbs;
    }
}

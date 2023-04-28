<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Datasource\FactoryLocator;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * System Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property int|null $system_category_id
 * @property string $configurable
 * @property float|null $cost
 * @property string $price_lock
 * @property string $url
 * @property string $name
 * @property string $name_line_1
 * @property string $name_line_2
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $force_perspective
 * @property string $category_browse
 * @property string $active
 * @property int $sort
 * @property \Cake\I18n\FrozenTime $date_added
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \ProductBackend\Model\Entity\Kit $kit
 * @property \ProductBackend\Model\Entity\SystemCategory $system_category
 * @property \ProductBackend\Model\Entity\GroupItem[] $group_items
 * @property \ProductBackend\Model\Entity\SystemItem[] $system_items
 * @property \ProductBackend\Model\Entity\SystemPerspective[] $system_perspectives
 * @property \ProductBackend\Model\Entity\SystemPriceLevel[] $system_price_levels
 */
class System extends Entity
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
        'kit_id' => true,
        'system_category_id' => true,
        'configurable' => true,
        'cost' => true,
        'price_lock' => true,
        'url' => true,
        'name' => true,
        'name_line_1' => true,
        'name_line_2' => true,
        'description' => true,
        'meta_title' => true,
        'meta_keywords' => true,
        'meta_description' => true,
        'force_perspective' => true,
        'category_browse' => true,
        'active' => true,
        'sort' => true,
        'date_added' => true,
        'timestamp' => true,
        'kit' => true,
        'system_category' => true,
        'group_items' => true,
        'system_items' => true,
        'system_perspectives' => true,
        'system_price_levels' => true,
    ];

    protected $_hidden = [
        '_matchingData',
    ];

    public function getBreadcrumbs($identifier = null)
    {
        if (!isset($this['system_category'])) {
            $this['system_category'] = FactoryLocator::get('Table')->get('ProductBackend.SystemCategories')
                ->get($this['system_category_id']);
        }

        $breadcrumbs = $this['system_category']->getBreadcrumbs();
        $breadcrumbs[] = [
            'title' => $this['name'],
            'url' => "/system/$this[url]" . ($identifier ? "/$identifier" : ''),
        ];

        return $breadcrumbs;
    }

    public function loadConfiguration($configuration = null)
    {
        if ($configuration) {
            $selectedItems = array_merge(...$configuration['config']);
            $subKitItems = array_filter($selectedItems, function ($selectedItem) {
                return isset($selectedItem['subkit']);
            });

            [$cost, $price] = TableRegistry::getTableLocator()->get('ProductBackend.Systems')
                ->getConfigurationCostAndPrice($configuration['config'], ['systemID' => $this['id']]);

            if (count($subKitItems) > 0) {
                $allItems = Hash::combine(
                    $this['buckets'],
                    '{n}.groups.{n}.group_items.{n}.id',
                    '{n}.groups.{n}.group_items.{n}'
                );

                // fill in sub-kits' details
                $subKitConfigItemIDs = array_unique(Hash::extract($subKitItems, '{n}.subkit.config.{n}.{n}.item_id'));
                $subKitConfigItems = TableRegistry::getTableLocator()->get('ProductBackend.GroupItems')
                    ->find('configuration')
                    ->whereInList('GroupItems.id', $subKitConfigItemIDs)
                    ->all()
                    ->indexBy('id')
                    ->toArray();

                $subKits = array_map(function ($subKitLine) use ($allItems, $subKitConfigItems) {
                    $subKit = $subKitLine['subkit'];
                    $subKitItem = $allItems[$subKitLine['item_id']];

                    [$cost, $price] = TableRegistry::getTableLocator()->get('ProductBackend.Systems')
                        ->getConfigurationCostAndPrice($subKit['config'], ['systemID' => $subKitItem['original_id']]);

                    $formattedSubKit = array_merge($subKitItem, [
                        'config_name' => $subKit['name'] ?? null,
                        'price' => $price,
                        'config_json' => $subKit,
                        'configuration' => array_map(function ($configDetail) use ($subKitConfigItems) {
                            return [
                                'item_id' => $configDetail['item_id'],
                                'name' => $subKitConfigItems[$configDetail['item_id']]['name'],
                                'quantity' => $configDetail['qty'],
                            ];
                        }, Hash::extract($subKit['config'], '{n}.{n}')),
                        'quantity' => $subKitLine['qty'],
                        'selected' => true,
                    ]);

                    if (Configure::read('ProductBackend.showCost')) {
                        $formattedSubKit['cost'] = $cost;
                    }

                    if (Configure::read('ProductBackend.showStock') && isset($subKitLine['sage_itemcode'])) {
                        $formattedSubKit['sage_itemcode'] = $subKitLine['sage_itemcode'];
                    }

                    return $formattedSubKit;
                }, $subKitItems);
            }

            $this['price'] = $price;
            $this['config_name'] = $configuration['name'] ?? null;
            $this['config_json'] = $configuration;

            $selectedNonSubKitItems = [];
            foreach ($selectedItems as $selectedItem) {
                if (!isset($selectedItem['subkit'])) {
                    $selectedNonSubKitItems[$selectedItem['item_id']] = $selectedItem['qty'];
                }
            }

            if (Configure::read('ProductBackend.showCost')) {
                $this['cost'] = $cost;
                $this['margin'] = ($price - $cost) / $price;
            }
        }

        // use base configuration
        if (!isset($selectedNonSubKitItems)) {
            $selectedNonSubKitItems = Hash::combine($this['system_items'], '{n}.item_id', '{n}.quantity');
        }

        $subKits = (new Collection($subKits ?? []))->groupBy('id')->toArray();

        foreach ($this['buckets'] as &$bucket) {
            $bucket['groups'] = array_map(function ($group) use ($subKits, $selectedNonSubKitItems) {
                $index = 0;
                foreach ($group['group_items'] as $groupItem) {
                    // insert selected sub-kits in each group
                    if ($selectedSubKits = $subKits[$groupItem['id']] ?? []) {
                        array_splice($group['group_items'], $index, 0, $selectedSubKits);
                        $index += count($selectedSubKits);
                    }
                    $index++;
                }

                // select items
                foreach ($group['group_items'] as &$groupItem) {
                    if ($quantity = $selectedNonSubKitItems[$groupItem['id']] ?? null) {
                        $groupItem['quantity'] = $quantity;
                        $groupItem['selected'] = true;
                    }
                }

                return $group;
            }, $bucket['groups']);
        }

        return $this;
    }

    public function generateBannerImage($width = 700, $height = 220)
    {
        $filesApiHandler = new \FilesApiHandler();
        $images = $filesApiHandler->getFileUrls([
            $banner['banner_id'] ?? null,
            $banner['tile_id'] ?? null,
            $this['image_id'] ?? null,
            ...Hash::extract($icons ?? [], '{n}.image_id'),
        ]);
        $image = imagecreatetruecolor($width, $height);
        imagesavealpha($image, true);
        $color_transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $color_transparent);

        $banner = $this['banner'];
        $icons = $this['kit']['icons'];

        // add tile
        if ($tileID = $banner['tile_id'] ?? null) {
            $tile = @imagecreatefrompng($images[$tileID]);

            if (empty($tile)) {
                $tile = $this->generate_system_banner_error(150, 25, "Error Loading tile $tileID");
            }

            $tileWidth = imagesx($tile);
            $tileHeight = imagesy($tile);

            for ($xpos = 0; $xpos <= $width; $xpos += $tileWidth) {
                for ($ypos = 0; $ypos <= $height; $ypos += $tileHeight) {
                    imagecopy($image, $tile, $xpos, $ypos, 0, 0, $tileWidth, $tileHeight);
                }
            }

            imagedestroy($tile);
        }

        // add background
        if ($bannerID = $banner['banner_id'] ?? null) {
            $background = @imagecreatefrompng($images[$bannerID]);

            if (empty($background)) {
                $background = $this->generate_system_banner_error(500, 220, "Error Loading banner $bannerID");
            }

            $backgroundWidth = imagesx($background);
            $backgroundHeight = imagesy($background);
            $left = 0;
            $top = 0;

            if ($banner['posx'] == "c") {
                $left = round(($width / 2) - ($backgroundWidth / 2), 2);
            }
            if ($banner['posx'] == "r") {
                $left = $width - $backgroundWidth;
            }
            if ($banner['posy'] == "c") {
                $top = round(($height / 2) - ($backgroundHeight / 2), 2);
            }
            if ($banner['posy'] == "b") {
                $top = $height - $backgroundHeight;
            }

            imagecopy($image, $background, $left, $top, 0, 0, $backgroundWidth, $backgroundHeight);
            imagedestroy($background);
        }

        // add system name
        $maxWidth = round($width * .6, 0) - 60;
        $freduce = 0;
        $fontFile = WWW_ROOT . "font/latoblack.ttf";

        while (true) {
            [$w1, $h1] = $this->generate_system_banner_ftbboxwh(21 - $freduce, $this['name_line_1'], $fontFile);
            if ($w1 > $maxWidth) {
                $freduce++;
            } else {
                break;
            }
        }

        while (true) {
            [$w2, $h2] = $this->generate_system_banner_ftbboxwh(24 - $freduce, $this['name_line_2'], $fontFile);
            if ($w2 > $maxWidth) {
                $freduce++;
            } else {
                break;
            }
        }

        [$w1, $h1] = $this->generate_system_banner_ftbboxwh(21 - $freduce, $this['name_line_1'], $fontFile);

        $lineHeight = $h1 + 8;
        $textTop = (int)floor($height / 4);

        $colorText1 = imagecolorallocatealpha($image, 178, 178, 178, 0);
        $colorText2 = imagecolorallocatealpha($image, 255, 255, 255, 0);
        $colorText3 = imagecolorallocatealpha($image, 55, 55, 55, 75);

        imagettftext($image, 21 - $freduce, 0, 32, $textTop + 1, $colorText3, $fontFile,
            $this['name_line_1']);
        imagettftext($image, 21 - $freduce, 0, 30, $textTop, $colorText1, $fontFile,
            $this['name_line_1']);
        imagettftext($image, 24 - $freduce, 0, 32, $textTop + 1 + $lineHeight, $colorText3, $fontFile,
            $this['name_line_2']);
        imagettftext($image, 24 - $freduce, 0, 30, $textTop + $lineHeight, $colorText2, $fontFile,
            $this['name_line_2']);

        // add system image
        $maxSystemImageWidth = floor($width * .4) - 30;
        $maxSystemImageHeight = floor($height) - 70;

        $systemImage = isset($this['image_id']) ? @imagecreatefrompng($images[$this['image_id']]) : null;

        if (empty($systemImage)) {
            $systemImage = $this->generate_system_banner_error(200, 150, "Error Loading image $this[image_id]");
        }

        $systemImageWidth = imagesx($systemImage);
        $systemImageHeight = imagesy($systemImage);
        $resize = false;

        if ($maxSystemImageWidth < $systemImageWidth || $maxSystemImageHeight < $systemImageHeight) {
            $resize = min($maxSystemImageWidth / $systemImageWidth, $maxSystemImageHeight / $systemImageHeight);
            $systemImageWidth = (int)floor($systemImageWidth * $resize);
            $systemImageHeight = (int)floor($systemImageHeight * $resize);
        }

        // add system shadow
        $shadow = @imagecreatefrompng(WWW_ROOT . 'img/shadow.png');
        if (empty($shadow)) {
            $shadow = $this->generate_system_banner_error(200, 150, "Error Loading shadow.png");
        }

        $systemImageLeftPosition = (int)round($width - $maxSystemImageWidth, 0) - 30;
        $systemImageTopPosition = (int)round(($height - $systemImageHeight - imagesy($shadow)) / 2, 0);

        imagecopyresampled($image, $systemImage, $systemImageLeftPosition, $systemImageTopPosition, 0, 0,
            $systemImageWidth, $systemImageHeight, imagesx($systemImage), imagesy($systemImage));
        imagecopyresampled($image, $shadow, $systemImageLeftPosition, $systemImageTopPosition + $systemImageHeight, 0,
            0, $systemImageWidth, imagesy($shadow), imagesx($shadow), imagesy($shadow));
        imagedestroy($systemImage);
        imagedestroy($shadow);

        // add system icons
        if (!empty($icons)) {
            $maxIconHeight = 0;

            foreach ($icons as $index => $icon) {
                $icon = isset($icon['image_id']) ? @imagecreatefrompng($images[$icon['image_id']]) : null;

                if (empty($icon)) {
                    $icon = $this->generate_system_banner_error(48, 48, "Error");
                }

                $icons[$index] = $icon;
                $iconHeight = imagesx($icon);

                if ($iconHeight > $maxIconHeight) {
                    $maxIconHeight = $iconHeight;
                }
            }

            $iconTopPosition = $height - 30 - $maxIconHeight;
            $iconLeftPosition = 30;
            $maxIconWidth = floor($width * .6);

            while (!empty($icons)) {
                $icon = array_shift($icons);
                $iconWidth = imagesx($icon);
                $iconHeight = imagesy($icon);

                if ($iconLeftPosition + $iconWidth < $maxIconWidth) {
                    $verticalPostionAdjustment = (int)round(($maxIconHeight - $iconHeight) / 2, 0);
                    imagecopyresampled($image, $icon, $iconLeftPosition, $iconTopPosition + $verticalPostionAdjustment,
                        0, 0, $iconWidth, $iconHeight, $iconWidth, $iconHeight);
                    $iconLeftPosition += $iconWidth + 10;
                } else {
                    break;
                }
            }
        }

        ob_start();
        imagepng($image);
        imagedestroy($image);

        return base64_encode(ob_get_clean());
    }

    private function generate_system_banner_ftbboxwh($size, $text, $font)
    {
        $rect = imagettfbbox($size, 0, $font, $text);

        return [
            max([$rect[0], $rect[2], $rect[4], $rect[6]]) - min([$rect[0], $rect[2], $rect[4], $rect[6]]),
            max([$rect[1], $rect[3], $rect[5], $rect[7]]) - min([$rect[1], $rect[3], $rect[5], $rect[7]])
        ];
    }

    private function generate_system_banner_error($width, $height, $text)
    {
        $image = imagecreatetruecolor($width, $height);
        $fontColor = imagecolorallocate($image, 255, 255, 0);
        $backgroundColor = imagecolorallocate($image, 0, 0, 0);
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);
        imagestring($image, 1, 3, 3, $text, $fontColor);

        return $image;
    }
}

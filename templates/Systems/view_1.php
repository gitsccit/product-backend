<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\System $system
 */

use Cake\Core\Configure;

$this->Html->script(['react@16.13.1.development', 'react-dom@16.13.1.development'], ['block' => true]);
$this->Breadcrumbs->add($breadcrumbs ?? []);

$system['price'] = $this->Number->currency($system['price']);
if (isset($system['cost'])) {
    $system['cost'] = $this->Number->currency($system['cost']);
}
$system['image'] = \ProductBackend\Core\Utility::getFileUrl($system['image_id'], 200, 200);

foreach ($system['buckets'] as &$bucket) {
    foreach ($bucket['groups'] as &$group) {
        foreach ($group['group_items'] as &$groupItem) {
            $groupItem['image'] = $groupItem['image_id'] ? \ProductBackend\Core\Utility::getFileUrl($groupItem['image_id'],
                100, 100) : null;
        }
    }
}
$priceLevels = json_encode($priceLevels, JSON_HEX_APOS);
$currentPriceLevel = $this->request->getQuery('priceLevel',
    $this->request->getSession()->read('options.store.price-level'));
$warehouses = json_encode($warehouses, JSON_HEX_APOS);
$currentWarehouse = $this->request->getQuery('warehouse',
    $this->request->getSession()->read('options.store.warehouse'));
$environmentID = $this->request->getQuery('environment_id', $this->request->getSession()->read('environment.id'));
$storeID = $this->request->getQuery('store_id', $this->request->getSession()->read('store.id'));
?>

<div id="configurator" data-tabs='<?= json_encode($tabs, JSON_HEX_APOS) ?>'
     data-system='<?= json_encode($system, JSON_HEX_APOS) ?>'
     data-base-url='<?= trim($this->Url->build('/', ['fullBase' => true]), '/') ?>'
     data-environment='<?= $environmentID ?>'
     data-store='<?= $storeID ?>'
     data-token='<?= Configure::read('Security.scctoken') ?>'
    <?= Configure::read('ProductBackend.showCost') ? "data-price-levels='$priceLevels'" : '' ?>
    <?= Configure::read('ProductBackend.showCost') ? "data-current-price-level='$currentPriceLevel'" : '' ?>
    <?= Configure::read('ProductBackend.showStock') ? "data-warehouses='$warehouses'" : '' ?>
    <?= Configure::read('ProductBackend.showStock') ? "data-current-warehouse='$currentWarehouse'" : '' ?>
     data-csrf='<?= $this->request->getCookie('csrfToken') ?>'></div>
<?= $this->Html->script('ProductBackend.__generated__/ConditionalWrapper'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configure'); ?>
<?= $this->Html->script('ProductBackend.__generated__/StorageSetup'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Summary'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configurator'); ?>


<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\System $system
 */

use Cake\Core\Configure;

$this->Breadcrumbs->add($breadcrumbs ?? []);

$system['image'] = \ProductBackend\Core\Utility::getFileUrl($system['image_id'], 200, 200);

foreach ($system['buckets'] as &$bucket) {
    foreach ($bucket['groups'] as &$group) {
        foreach ($group['group_items'] as &$groupItem) {
            $groupItem['image'] = $groupItem['image_id'] ? \ProductBackend\Core\Utility::getFileUrl(
                $groupItem['image_id'],
                100,
                100
            ) : null;
        }
    }
}
$priceLevels = json_encode($priceLevels, JSON_HEX_APOS);
$currentPriceLevel = $this->request->getQuery(
    'priceLevel',
    $this->request->getSession()->read('options.store.price-level')
);
$warehouses = json_encode($warehouses, JSON_HEX_APOS);
$currentWarehouse = $this->request->getQuery(
    'warehouse',
    $this->request->getSession()->read('options.store.warehouse')
);
$environmentID = $this->request->getQuery('environment_id', $this->request->getSession()->read('environment.id'));
$storeID = $this->request->getQuery('store_id', $this->request->getSession()->read('store.id'));
$configuringSubKit = false;
?>

<style>
    .tooltip-inner {
        font-size: 11px;
        max-width: 100%;
    }
</style>

<div id="configurator" data-tabs='<?= json_encode($tabs, JSON_HEX_APOS) ?>'
     data-currency='<?= \Cake\I18n\Number::getDefaultCurrency() ?>'
     data-system='<?= json_encode($system, JSON_HEX_APOS) ?>'
     data-opportunity='<?= null ?>'
     data-base-url='<?= trim($this->Url->build('/', ['fullBase' => true]), '/') ?>'
     data-apps-url='<?= trim(Configure::read('Urls.apps', $this->Url->build('/', ['fullBase' => true])), '/') ?>'
     data-environment-id='<?= $environmentID ?>'
     data-store-id='<?= $storeID ?>'
     data-token='<?= Configure::read('Security.scctoken') ?>'
     data-configuring-sub-kit='<?= $configuringSubKit ?>'
    <?= Configure::read('ProductBackend.showCost') ? "data-price-levels='$priceLevels'" : '' ?>
    <?= Configure::read('ProductBackend.showCost') ? "data-current-price-level='$currentPriceLevel'" : '' ?>
    <?= Configure::read('ProductBackend.showStock') ? "data-warehouses='$warehouses'" : '' ?>
    <?= Configure::read('ProductBackend.showStock') ? "data-current-warehouse='$currentWarehouse'" : '' ?>
     data-csrf='<?= $this->request->getCookie('csrfToken') ?>'></div>
<?= $this->Html->script('ProductBackend.bootstrap.bundle.min'); ?>
<?= $this->Html->script('ProductBackend.__generated__/ConditionalWrapper'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configure'); ?>
<?= $this->Html->script('ProductBackend.__generated__/StorageSetup'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Summary'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configurator'); ?>


<?php
/**
 * @var \App\View\AppView $this
 * @var \ProductBackend\Model\Entity\System $system
 */

use Cake\Core\Configure;

$this->Breadcrumbs->add($breadcrumbs ?? []);

$priceLevels = json_encode($priceLevels ?? null, JSON_HEX_APOS);
$currentPriceLevel = $this->request->getQuery(
    'priceLevel',
    $this->request->getSession()->read('store.price_level')
);
$warehouses = json_encode($warehouses ?? null, JSON_HEX_APOS);
$currentWarehouse = $this->request->getQuery(
    'warehouse',
    $this->request->getSession()->read('store.warehouse')
);
?>

<style>
    .tooltip-inner {
        font-size: 11px;
        max-width: 100%;
    }

    .bucket-link {
        background-color: var(--background-color-2);
        color: var(--bs-secondary-color) !important;
    }

    .bucket-link.active {
        color: var(--black) !important;
        border-top: 0 !important;
        background-color: var(--background-color-4);
        border-color: var(--primary-color) !important;
    }
</style>

<div id="configurator" data-tabs='<?= json_encode($tabs, JSON_HEX_APOS) ?>'
     data-currency='<?= \Cake\I18n\Number::getDefaultCurrency() ?>'
     data-system='<?= json_encode($system, JSON_HEX_APOS) ?>'
     data-base-url='<?= trim($this->Url->build('/', ['fullBase' => true]), '/') ?>'
     data-opportunity-key='<?= $opportunityKey ?>'
     data-config-key='<?= $configKey ?>'
     data-sub-kit-path='<?= $subKitPath ?>'
     data-system-url='<?= $systemUrl ?>'
    <?= Configure::read('ProductBackend.showCost') ? "data-price-levels='$priceLevels'" : '' ?>
    <?= Configure::read('ProductBackend.showCost') ? "data-current-price-level='$currentPriceLevel'" : '' ?>
    <?= Configure::read('ProductBackend.showStock') ? "data-warehouses='$warehouses'" : '' ?>
    <?= Configure::read('ProductBackend.showStock') ? "data-current-warehouse='$currentWarehouse'" : '' ?>
     data-csrf='<?= $this->request->getCookie('csrfToken') ?>'></div>
<?= $this->Html->script('ProductBackend.bootstrap.bundle.min'); ?>
<?= $this->Html->script('ProductBackend.__generated__/ConditionalWrapper'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Modal'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configure'); ?>
<?= $this->Html->script('ProductBackend.__generated__/StorageSetup'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Summary'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configurator'); ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\System $system
 */
$this->Html->script(['react@16.13.1.development', 'react-dom@16.13.1.development'], ['block' => true]);
$this->Breadcrumbs->add($breadcrumbs ?? []);

$system['price'] = $this->Number->currency($system['price']);
$system['image'] = \ProductBackend\Core\Utility::getFileUrl($system['image_id'], 200, 200);

foreach ($system['buckets'] as &$bucket) {
    foreach ($bucket['groups'] as &$group) {
        foreach ($group['group_items'] as &$groupItem) {
            $groupItem['image'] = $groupItem['image_id'] ? \ProductBackend\Core\Utility::getFileUrl($groupItem['image_id'],
                100, 100) : null;
        }
    }
}
?>

<div id="configurator" data-tabs='<?= json_encode($tabs, JSON_HEX_APOS) ?>'
     data-system='<?= json_encode($system, JSON_HEX_APOS) ?>'
     data-csrf='<?= $this->request->getCookie('csrfToken') ?>'></div>
<?= $this->Html->script('ProductBackend.__generated__/ConditionalWrapper'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configure'); ?>
<?= $this->Html->script('ProductBackend.__generated__/StorageSetup'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Summary'); ?>
<?= $this->Html->script('ProductBackend.__generated__/Configurator'); ?>


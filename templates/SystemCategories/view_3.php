<?php
/**
 * @var \App\View\AppView $this
 * @var \ProductBackend\Model\Entity\SystemCategory $systemCategory
 * @var \ProductBackend\Model\Entity\System[] $systems
 * @var array $tagGroups
 */
$this->Breadcrumbs->add($breadcrumbs ?? []);
?>
<div class="container py-5">
    <h1 class="mb-5">Browse & <span class="text-primary">Configure</span></h1>
    <div class="row">
        <?php if ($tagGroups) : ?>
            <div class="col-md-3">
                <?= $this->element('ProductBackend.filters/thinkmate', ['filters' => $tagGroups]) ?>
            </div>
        <?php endif; ?>
        <div class="<?= $tagGroups ? 'col-md-9' : 'col-12' ?>">
            <?= $this->element('ProductBackend.paginator/2') ?>
            <hr class="border-black">
            <div class="row">
                <?php foreach ($systems as $card) : ?>
                    <div class="col-lg-4 col-sm-6 p-3">
                        <?= $this->element('ProductBackend.cards/system_3', compact('card')) ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr class="border-black">
            <?= $this->element('ProductBackend.paginator/2') ?>
        </div>
    </div>
</div>

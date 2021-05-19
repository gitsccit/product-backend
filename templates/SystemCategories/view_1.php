<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SystemCategory $systemCategory
 * @var \App\Model\Entity\System[] $systems
 * @var array $tagCategories
 */
$this->Breadcrumbs->add($breadcrumbs ?? []);
?>
<div class="container py-5">
    <h1 class="mb-5">Browse & <span class="text-primary">Configure</span></h1>
    <div class="row">
        <?php if ($tagCategories): ?>
            <div class="col-md-3">
                <?= $this->element('ProductBackend.filters/thinkmate', ['filters' => $tagCategories]) ?>
            </div>
        <?php endif; ?>
        <div class="<?= $tagCategories ? 'col-md-9' : 'col-12' ?>">
            <?= $this->element('ProductBackend.paginator/2') ?>
            <hr>
            <?php foreach ($systems as $card) : ?>
                <?= $this->element('ProductBackend.cards/system_1', compact('card')) ?>
            <?php endforeach; ?>
            <hr>
            <?= $this->element('ProductBackend.paginator/2') ?>
        </div>
    </div>
</div>

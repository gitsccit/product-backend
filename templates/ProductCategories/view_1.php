<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductCategory $productCategory
 * @var \App\Model\Entity\Product[] $products
 * @var array $specifications
 */
$this->Breadcrumbs->add($breadcrumbs ?? []);
?>
<div class="container py-5">
    <?= $this->element('ProductBackend.compare') ?>
    <h1 class="mb-5"><?= $productCategory->name ?></h1>
    <div class="row">
        <?php if ($specifications) : ?>
            <div class="col-md-3">
                <?= $this->element('ProductBackend.filters/thinkmate', ['filters' => $specifications]) ?>
            </div>
        <?php endif; ?>
        <div class="<?= $specifications ? 'col-md-9' : 'col-12' ?>">
            <?= $this->element('ProductBackend.paginator/2') ?>
            <hr>
            <?php foreach ($products as $card) : ?>
                <?= $this->element('ProductBackend.cards/product_1', compact('card')) ?>
            <?php endforeach; ?>
            <hr>
            <?= $this->element('ProductBackend.paginator/2') ?>
        </div>
    </div>
</div>

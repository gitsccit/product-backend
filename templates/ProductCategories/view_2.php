<?php
/**
 * @var \App\View\AppView $this
 * @var \ProductBackend\Model\Entity\ProductCategory $productCategory
 * @var \ProductBackend\Model\Entity\Product[] $products
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
        <?php endif ?>
        <div class="<?= $specifications ? 'col-md-9' : 'col-12' ?>">
            <?= $this->element('ProductBackend.paginator/2') ?>
            <hr>
            <div class="row">
                <?php foreach ($products as $card) : ?>
                    <div class="col-lg-4 col-md-6 p-3">
                        <?= $this->element('ProductBackend.cards/product_2', compact('card')) ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <?= $this->element('ProductBackend.paginator/2') ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductCategory[]|\Cake\Collection\CollectionInterface $productCategories
 */
$this->Breadcrumbs->add($breadcrumbs);
?>

<div class="container py-5">
    <?= $this->element('ProductBackend.cards/category_4', [
        'category' => [
            'name' => 'Hardware',
            'children' => $productCategories,
        ],
    ]); ?>
</div>

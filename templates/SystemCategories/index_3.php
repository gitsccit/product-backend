<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SystemCategory[]|\Cake\Collection\CollectionInterface $systemCategories
 */

$subCategories = $this->request->getParam('pass');
$this->Breadcrumbs->add($breadcrumbs ?? []);
?>
<div class="container py-5">
    <?php if ($subCategories) : ?>
        <?= $this->element('ProductBackend.cards/category_3', [
            'category' => [
                'name' => humanize(end($subCategories)),
                'children' => $systemCategories,
            ],
        ]) ?>
    <?php else : ?>
        <?php foreach ($systemCategories as $category) : ?>
            <?= $this->element('ProductBackend.cards/category_3', compact('category')) ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

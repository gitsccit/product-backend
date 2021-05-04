<?php
/**
 * @var \App\View\AppView $this
 * @var string $title
 * @var string $description
 * @var string $content
 */
?>

<div class="container d-flex flex-column align-items-center py-5">
    <!-- Title -->
    <?php if (isset($title)) : ?>
        <h1 class="text-center fw-bold mb-3"><?= $title ?></h1>
    <?php endif; ?>

    <!-- Description -->
    <?php if (isset($description)) : ?>
        <p class="text-center mb-5"><?= $description ?></p>
    <?php endif; ?>

    <!-- Content -->
    <?php if (isset($content)) : ?>
        <?= $content ?>
    <?php endif; ?>
</div>

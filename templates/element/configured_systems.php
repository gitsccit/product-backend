<?php
/**
 * @var \App\View\AppView $this
 * @var array $systems
 */
?>
<div class="py-5" style="background-color: #f2f2f2">
    <div class="container">
        <h4 class="mb-3">This barebone is available as a fully configured system:</h4>
        <p class="mb-5"><?= $this->request->getSession()->read('store.name') ?> pre-configured servers illustrate a
            configuration opportunity for the barebone server above. You may start your very own configuration from
            scratch, or you may begin customizing your configuration from our recommended starting point below.</p>
        <?php foreach ($systems as $card) : ?>
            <?= $this->element('ProductBackend.cards/system_1', compact('card')) ?>
        <?php endforeach; ?>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var array $card
 */

$url = $this->Url->build("/system/$card[url]" . (isset($opportunityKey) ? "/$opportunityKey" : ''));
?>
<div class="d-flex flex-column align-items-center p-4 bg-white text-center">
    <a class="d-flex align-items-center justify-content-center p-3" href="<?= $url ?>" style="height: 100px">
        <img class="mw-100 mh-100" src="<?= $card['image'] ?>"
             alt="<?= $card['name'] ?>">
    </a>
    <p class="fw-bold mb-1"><?= $card['name'] ?></p>
    <p class="mb-1">Starting Price: <?= $this->Number->currency($card['price']) ?></p>
    <a class="text-primary text-nowrap" href="<?= $url ?>">Configure &#10095;</a>
</div>

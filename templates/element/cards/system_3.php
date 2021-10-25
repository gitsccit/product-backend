<?php
/**
 * @var \App\View\AppView $this
 * @var array $card
 */

$url = $this->Url->build("/system/$card[url]" . (isset($opportunityKey) ? "/$opportunityKey" : ''));
?>
<div class="d-flex flex-column bg-3 h-100 shadow">
    <a class="d-flex p-3 bg-white text-decoration-none" href="<?= $url ?>">
        <div class="d-flex flex-column align-items-center w-100 h-100">
            <div class="d-flex justify-content-between h5 fw-bold text-black w-100 mb-3" style="height: 38px;">
                <span class="col-8 p-0">
                    <?= $card['name'] ?>
                </span>
                <span class="p-0" data-bs-toggle="tooltip" data-placement="bottom"
                      title="<?= $card['support_badge_info'] ?? '' ?>">
                    <?= $card['support_badge'] ?? '' ?>
                </span>
            </div>
            <img class="mw-100 mb-4" src="<?= \ProductBackend\Core\Utility::getFileUrl($card['image_id'], 100, 70) ?>"
                 style="height: 70px" alt="<?= $card['name'] ?>">
        </div>
    </a>
    <div class="d-flex flex-column flex-fill p-4">
        <div class="h4 text-primary">Supports:</div>
        <div class="d-flex flex-column my-2">
            <?php foreach ($card['tags'] as $tag) : ?>
                <div class="d-flex">
                    <div style="width:20px; height: 20px" class="d-flex justify-content-center align-items-center me-2">
                        <img class="mw-100 mh-100"
                             src="<?= \ProductBackend\Core\Utility::getFileUrl($tag['image_id']) ?>">
                    </div>
                    <div>
                        <?php if ($tag['value']) : ?>
                            <span class="text-primary fw-bold"><?= $tag['value'] ?></span>
                        <?php endif; ?>
                        <?= $tag['name'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="d-flex w-100">
        <div class="d-flex flex-grow-1 justify-content-center flex-column py-1 px-3" style="background-color: black">
            <div class="p-0 text-white text-nowrap">STARTING PRICE</div>
            <div class="fw-bold" style="color: #ff9900">
                <?= $this->Number->currency($card['price']) ?>
            </div>
        </div>
        <a class="d-flex align-items-center btn btn-primary fw-bold text-nowrap p-3"
           href="<?= $url ?>">CONFIGURE</a>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var array $card
 */

$url = $this->Url->build("/product/$card[url]");
?>
<div class="d-flex flex-column bg-3 h-100 shadow">
    <div class="d-flex flex-column">
        <a class="d-flex justify-content-center align-items-center p-5 bg-white" href="<?= $url ?>"
           style="height: 150px">
            <img class="mw-100 mh-100" src="<?= \ProductBackend\Core\Utility::getFileUrl($card['image_id'], 100, 70) ?>"
                 alt="<?= $card['name'] ?>">
        </a>
        <div class="d-flex flex-row bg-4 justify-content-center align-items-center">
            <label class="my-2 d-flex align-items-center" for="compare">
                <input class="product-compare" type="checkbox" name="<?= $card['id'] ?>">
                <a class="ms-1 text-dark" href="#compare" data-bs-toggle="modal" data-bs-target="#compare-modal"
                   onclick="product_compare('<?= $this->Url->build('/') ?>', <?= $card['id'] ?>)">Compare</a>
            </label>
        </div>
    </div>
    <div class="d-flex flex-column flex-fill p-4">
        <a class="h5 text-black text-decoration-none text-on-hover-primary fw-bold mb-3" href="<?= $url ?>">
            <?= $card['name'] ?>
        </a>
        <div class="d-flex flex-column flex-fill justify-content-between">
            <p class="text-small"><?= str_replace('<br>', ', ', $card['specs_overview']) ?></p>
            <div class="d-flex flex-column justify-content-between">
                <div class="d-flex">
                    <p class="fw-bold">Availability:&nbsp;</p>
                    <p><?= $card['status'] ?></p>
                </div>
                <p class="h4 fw-bold mb-3"><?= $this->Number->currency($card['price']) ?></p>
                <a class="btn btn-primary text-nowrap" href="<?= $this->Url->build("/order/add/$card[id]") ?>">
                    Add To Order
                </a>
            </div>
        </div>
    </div>
</div>

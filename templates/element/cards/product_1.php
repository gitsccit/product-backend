<?php
/**
 * @var \App\View\AppView $this
 * @var array $card
 */

$url = $this->Url->build("/product/$card[url]" . (isset($opportunityKey) ? "/$opportunityKey" : ''));
?>
<div class="bg-3 my-3 shadow">
    <div class="row">
        <div class="col-lg-3">
            <div class="d-flex flex-column align-items-center bg-white h-100">
                <a class="d-flex align-items-center justify-content-center p-5 w-100" href="<?= $url ?>"
                   style="height: 150px">
                    <img class="mw-100 mh-100"
                         src="<?= $this->filesApiHandler->getFileUrl($card['image_id'], 100, 70) ?>"
                         alt="<?= $card['name'] ?>">
                </a>
                <label class="mt-3 my-2 d-flex align-items-center" for="compare">
                    <input class="product-compare" type="checkbox" name="<?= $card['id'] ?>">
                    <a class="ms-1 text-dark" href="javascript:void(0)" data-bs-toggle="modal"
                       data-bs-target="#compare-modal"
                       onclick="product_compare('<?= $this->Url->build('/') ?>', <?= $card['id'] ?>)">
                        Compare
                    </a>
                </label>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row p-3 ps-md-0 h-100">
                <div class="col-lg-8">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <a class="h5 text-black text-on-hover-primary text-decoration-none fw-bold"
                           href="<?= $url ?>"><?= $card['name'] ?></a>
                        <p class="text-small"><?= $card['specs_overview'] ?></p>
                        <?php if ($manufacturer = $card['manufacturer']) : ?>
                            <div class="text-muted text-small mb-3 mb-lg-0">
                                <?= "$manufacturer[name] part #: $card[part_number]" ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-column justify-content-center h-100">
                        <p class="h5 fw-bold"><?= $this->Number->currency($card['price']) ?></p>
                        <div class="d-flex flex-wrap">
                            <p class="fw-bold">Availability:&nbsp;</p>
                            <p><?= $card['status'] ?></p>
                        </div>
                        <input class="form-control mb-3" style="width: 4rem" type="number" name="quantity"
                               min="1" value="1">
                        <a class="btn btn-primary text-nowrap"
                           href="<?= $this->Url->build([
                               'controller' => 'Products',
                               'action' => 'save',
                               'plugin' => 'ProductBackend',
                               $card['id'],
                               $opportunityKey ?? null,
                           ]) ?>">
                            Add To Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

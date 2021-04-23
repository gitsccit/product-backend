<?php
/**
 * @var \App\View\AppView $this
 * @var array $images
 */
?>
<div class="modal fade" id="modal-gallery" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content bg-2">
            <div class="row m-0">
                <div class="col-md-4 p-3 bg-3">
                    <ul class="row nav m-0" id="gallery-nav-bar" role="tablist">
                        <?php foreach ($images as $index => $image): ?>
                            <li class="col-6 p-2">
                                <a class="d-flex justify-content-center align-items-center bg-white image-tab p-1<?= $index === 0 ? ' active' : '' ?>"
                                   id="modal-image-<?= $image['id'] ?>-tab" data-toggle="tab" href="#modal-image-<?= $image['id'] ?>" role="tab" style="height: 60px">
                                    <img class="mw-100 mh-100" src="<?= $this->apiHandler->getFileUrl($image['file_id'], 300, 200) ?>">
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-8 p-3">
                    <div class="d-flex justify-content-end">
                        <a href="#close-modal" data-dismiss="modal" aria-label="Close">
                            <span class="bg-black text-white icon-cancel" aria-hidden="true"></span>
                        </a>
                    </div>
                    <div class="p-3">
                        <h5 class="mb-3"><?= $product['name'] ?></h5>
                        <div class="tab-content" id="modal-gallery-content">
                            <?php foreach ($images as $index => $image): ?>
                                <div class="tab-pane fade<?= $index === 0 ? ' show active' : '' ?>"
                                     id="modal-image-<?= $image['id'] ?>" role="tabpanel">
                                    <div class="d-flex justify-content-center align-items-center bg-white image-tab p-5"
                                         style="height: 300px">
                                        <img class="mw-100 mh-100" src="<?= $this->apiHandler->getFileUrl($image['file_id'], 300, 200) ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

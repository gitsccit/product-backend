<?php
/**
 * @var \App\View\AppView $this
 * @var array $images
 */
$slideSize = 6;
$hasOneSlide = count($images) <= $slideSize;
?>
<div class="modal fade" id="modal-gallery" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content bg-2">
            <div class="p-3 bg-3">
                <div class="d-flex justify-content-end">
                    <a href="#close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <span class="bg-black text-white icon-cancel" aria-hidden="true"></span>
                    </a>
                </div>
                <h5 class="mb-3"><?= $product['name'] ?></h5>
                <div id="modal-gallery-carousel-controls" class="carousel slide p-3 px-5"
                     data-interval="false">
                    <div class="carousel-inner">
                        <?php foreach (array_chunk($images, $slideSize) as $i => $slideOfImages) : ?>
                            <div class="carousel-item<?= $i === 0 ? ' active' : '' ?>">
                                <ul class="row nav m-0" id="gallery-nav-bar" role="tablist">
                                    <?php foreach ($slideOfImages as $j => $image) : ?>
                                        <li class="col-2 p-2">
                                            <a class="d-flex justify-content-center align-items-center bg-white image-tab p-1<?= $i === 0 && $j === 0 ? ' active' : '' ?>"
                                               id="modal-image-<?= $image['id'] ?>-tab" data-bs-toggle="tab"
                                               href="#modal-image-<?= $image['id'] ?>" role="tab" style="height: 80px">
                                                <img class="mw-100 mh-100"
                                                     src="<?= $filesApiHandler->getFileUrl(
                                                         $image['file_id'],
                                                         300,
                                                         200
                                                     ) ?>">
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev<?= $hasOneSlide ? ' opacity-1 no-hover' : '' ?>"
                       href="#modal-gallery-carousel-controls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon text-black" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next<?= $hasOneSlide ? ' opacity-1 no-hover' : '' ?>"
                       href="#modal-gallery-carousel-controls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="p-5">
                <div class="tab-content" id="modal-gallery-content">
                    <?php foreach ($images as $index => $image) : ?>
                        <div class="tab-pane fade<?= $index === 0 ? ' show active' : '' ?>"
                             id="modal-image-<?= $image['id'] ?>" role="tabpanel">
                            <div class="d-flex justify-content-center align-items-center bg-white image-tab p-5"
                                 style="height: 300px">
                                <img class="mw-100 mh-100"
                                     src="<?= $filesApiHandler->getFileUrl($image['file_id'], 300, 200) ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

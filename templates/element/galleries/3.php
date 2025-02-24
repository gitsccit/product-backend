<?php
/**
 * @var \App\View\AppView $this
 * @var array $images
 */
?>
<div class="row" style="margin-left: -.25rem; margin-right: -.25rem">
    <?= $this->element(
        'ProductBackend.galleries/modal_' . $this->request->getSession()->read('store.layout_gallery'),
        compact('images')
    ) ?>
    <ul class="col-3 px-1 item-group-vertical d-flex flex-column nav" id="gallery-nav-bar" role="tablist">
        <?php foreach ((count($images) > 5 ? array_slice($images, 0, 4) : $images) as $index => $image) : ?>
            <li>
                <a class="d-flex justify-content-center align-items-center bg-white image-tab p-1<?= $index === 0 ? ' active' : '' ?>"
                   id="image-<?= $index ?>-tab" data-bs-toggle="tab" href="#image-<?= $index ?>" role="tab"
                   style="height: 50px">
                    <img class="mw-100 mh-100" src="<?= $image ?>">
                </a>
            </li>
        <?php endforeach; ?>
        <?php if (count($images) > 5) : ?>
            <li style="height: 50px">
                <a class="w-100 h-100 d-flex justify-content-center align-items-center bg-white p-1 text-black image-tab" id="see-all-images-tab" data-bs-toggle="modal" href="#see-all-images" role="tab"
                   data-bs-target="#modal-gallery">
                    See All
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="col-9 px-1 tab-content" id="gallery-content">
        <?php foreach ((count($images) > 5 ? array_slice($images, 0, 4) : $images) as $index => $image) : ?>
            <div class="tab-pane fade<?= $index === 0 ? ' show active' : '' ?>" id="image-<?= $index ?>"
                 role="tabpanel">
                <a class="d-flex justify-content-center align-items-center bg-white image-tab p-5" style="height: 290px"
                   data-bs-toggle="modal" data-bs-target="#modal-gallery">
                    <img class="mw-100 mh-100" src="<?= $image ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

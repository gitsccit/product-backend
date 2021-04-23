<?php
/**
 * @var \App\View\AppView $this
 * @var array $images
 */
?>
<div class="d-flex flex-column">
    <?= $this->element('galleries/modal_' . $this->request->getSession()->read('options.store.layout.gallery'),
        compact('images')) ?>
    <div class="tab-content" id="gallery-content">
        <?php foreach (array_slice($images, 0, 6) as $index => $image): ?>
            <div class="tab-pane fade<?= $index === 0 ? ' show active' : '' ?>" id="image-<?= $image['id'] ?>"
                 role="tabpanel">
                <a class="d-flex justify-content-center align-items-center bg-white p-5 image-tab"
                   style="height: 240px" data-toggle="modal" data-target="#modal-gallery">
                    <img class="mw-100 mh-100" src="<?= $this->apiHandler->getFileUrl($image['file_id'], 300, 200) ?>">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <ul class="row nav" id="gallery-nav-bar" role="tablist" style="margin-left: -.25rem; margin-right: -.25rem">
        <?php foreach (array_slice($images, 0, 6) as $index => $image): ?>
            <li class="col-2 px-1 py-2">
                <a class="d-flex justify-content-center align-items-center bg-white image-tab p-1<?= $index === 0 ? ' active' : '' ?>"
                   id="image-<?= $image['id'] ?>-tab" data-toggle="tab" href="#image-<?= $image['id'] ?>" role="tab"
                   style="height: 60px">
                    <img class="mw-100 mh-100" src="<?= $this->apiHandler->getFileUrl($image['file_id'], 300, 200) ?>">
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a class="align-self-center p-1 text-primary"
       id="see-all-images-tab" data-toggle="modal" href="#see-all-images" role="tab"
       data-target="#modal-gallery">
        View Image Gallery
    </a>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var array $category
 */
?>

<div class="py-3">
    <div class="h4 fw-bold"><?= $category['name'] ?></div>
    <div class="row">
        <?php foreach ($category['children'] as $subCategory) : ?>
            <?php $categoryUrl = \Cake\Routing\Router::url($this->request->getPath() . (isset($category['url']) ? "/$category[url]" : '') . "/$subCategory[url]" . (isset($opportunityKey) ? "/$opportunityKey" : '')) ?>
            <div class="col-lg-3 col-sm-4 py-3">
                <div class="d-flex flex-column align-items-center bg-3 p-4 h-100 shadow">
                    <h5 class="fw-bold text-center mb-3"><?= $this->Text->truncate($subCategory['name'], 40,
                            ['exact' => false]) ?></h5>
                    <div class="square-container w-100">
                        <a class="w-100 h-100 d-flex align-items-center justify-content-center p-5 bg-white"
                           href="<?= $categoryUrl ?>">
                            <img class="mw-100 mh-100"
                                 src="<?= $this->filesApiHandler->getFileUrl(($subCategory['products'] ?? $subCategory['systems'])[0]['image_id'], 100) ?>"
                                 alt="<?= $subCategory['name'] ?>">
                        </a>
                    </div>
                    <a class="mt-3 text-primary" href="<?= $categoryUrl ?>">
                        See more &#10095;
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

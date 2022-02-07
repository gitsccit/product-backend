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
            <?php $categoryUrl = \Cake\Routing\Router::url($this->request->getPath() . (isset($category['url']) ? "/$category[url]" : '') . "/$subCategory[url]") ?>
            <div class="col-lg-3 col-sm-4 py-3">
                <div class="d-flex flex-column bg-3 h-100 shadow">
                    <a class="d-flex align-items-center justify-content-center p-5 bg-white" href="<?= $categoryUrl ?>"
                       style="height: 150px">
                        <img class="mw-100 mh-100"
                             src="<?= $this->filesApiHandler->getFileUrl(($subCategory['products'] ?? $subCategory['systems'])[0]['image_id'],
                                 100) ?>"
                             alt="<?= $subCategory['name'] ?>">
                    </a>
                    <div class="d-flex flex-column p-4 flex-grow-1 align-items-center">
                        <p class="h5 fw-bold text-center"><?= $this->Text->truncate($subCategory['name'], 40,
                                ['exact' => false]) ?></p>
                        <p><?= $this->Text->truncate($subCategory['description'] ?? '', 100, ['exact' => false]) ?></p>
                        <a class="align-self-center mt-auto text-primary" href="<?= $categoryUrl ?>">
                            See more
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

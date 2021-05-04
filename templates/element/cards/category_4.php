<?php
/**
 * @var \App\View\AppView $this
 * @var array $category
 */
?>

<div class="py-3">
    <div class="h4 fw-bold"><?= $category['name'] ?></div>
    <div class="row">
        <?php foreach ($category['children'] as $subCategory): ?>
            <?php $categoryUrl = \Cake\Routing\Router::url($this->request->getPath() . (isset($category['url']) ? "/$category[url]" : '') . "/$subCategory[url]") ?>
            <div class="col-lg-3 col-sm-4 py-3">
                <div class="d-flex flex-column bg-3 h-100 shadow">
                    <a class="d-flex align-items-center justify-content-center p-5 bg-white" href="<?= $categoryUrl ?>"
                       style="height: 150px">
                        <img class="mw-100 mh-100"
                             src="<?= $this->apiHandler->getFileUrl(($subCategory['products'] ?? $subCategory['systems'])[0]['image_id'],
                                 100) ?>"
                             alt="<?= $subCategory['name'] ?>">
                    </a>
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <a class="text-primary fw-bold" href="<?= $categoryUrl ?>">
                            <?= $this->Text->truncate($subCategory['name'], 30, ['exact' => false]) ?>
                        </a>
                        <div>
                            <?= "$subCategory[product_count] products" ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

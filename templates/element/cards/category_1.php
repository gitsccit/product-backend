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
            <div class="col-xl-4 col-md-6 py-3">
                <div class="d-flex flex-row bg-3 h-100 shadow">
                    <div class="col-lg-5 px-0">
                        <div class="square-container">
                            <a class="w-100 h-100 d-flex align-items-center justify-content-center p-5 bg-white"
                               href="<?= $categoryUrl ?>">
                                <img class="mw-100 mh-100"
                                     src="<?= ($subCategory['products'] ?? $subCategory['systems'])[0]['image'] ?>"
                                     alt="<?= $subCategory['name'] ?>">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="d-flex flex-column p-4 justify-content-around h-100">
                            <p class="h5 fw-bold"><?= $this->Text->truncate($subCategory['name'], 30,
                                    ['exact' => false]) ?></p>
                            <a class="btn btn-primary" href="<?= $categoryUrl ?>">
                                See more
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

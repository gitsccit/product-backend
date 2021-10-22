<?php
/**
 * @var \App\View\AppView $this
 * @var array $card
 */

$url = $this->Url->build(['controller' => 'Systems', 'action' => 'view', $card['url'], $opportunityKey]);

$card['tags'] = (new \Cake\Collection\Collection($card['tags']))->groupBy('category')->toArray();
?>
<div class="bg-3 my-3 shadow">
    <div class="row">
        <div class="col-md-3 d-flex flex-column align-items-center">
            <a class="d-flex p-3 bg-white text-decoration-none d-flex flex-column align-items-center w-100 h-100"
               href="<?= $url ?>">
                <div class="d-flex justify-content-between h6 fw-bold text-black w-100 mb-3">
                    <span class="col-8 p-0"><?= $card['name'] ?></span>
                    <span class="p-0" data-bs-toggle="tooltip" data-placement="bottom"
                          title="<?= $card['support_badge_info'] ?? '' ?>">
                        <?= $card['support_badge'] ?? '' ?>
                    </span>
                </div>
                <img class="mw-100 my-2"
                     src="<?= \ProductBackend\Core\Utility::getFileUrl($card['image_id'], 100, 70) ?>"
                     style="height: 70px" alt="<?= $card['name'] ?>">
            </a>
        </div>
        <div class="col-md-9">
            <div class="row p-3 ps-md-0 h-100">
                <div class="col-md-9">
                    <div class="row align-items-stretch h-100">
                        <?php foreach (array_slice($card['tags'], 0, 4) as $tagCategory => $tags) : ?>
                            <div class="col-3 d-flex flex-column">
                                <span class="fw-bolder"><?= $tagCategory ?></span>
                                <div class="d-flex flex-column justify-content-center flex-grow-1">
                                    <?php foreach ($tags as $tag) : ?>
                                        <div class="d-flex align-items-center">
                                            <div style="width:20px; height: 20px"
                                                 class="d-flex justify-content-center align-items-center me-1">
                                                <img class="mw-100 mh-100"
                                                     src="<?= \ProductBackend\Core\Utility::getFileUrl($tag['image_id']) ?>">
                                            </div>
                                            <div class="text-small">
                                                <?php if ($tag['value']) : ?>
                                                    <span class="text-primary fw-bold"><?= $tag['value'] ?></span>
                                                <?php endif; ?>
                                                <?= $tag['name'] ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column h-100">
                        STARTING PRICE
                        <div class="d-flex flex-column justify-content-center flex-fill">
                            <p class="h5 fw-bold"><?= $this->Number->currency($card['price']) ?></p>
                            <a class="btn btn-primary text-nowrap" href="<?= $url ?>">Configure</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

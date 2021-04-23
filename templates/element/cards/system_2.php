<?php
/**
 * @var \App\View\AppView $this
 * @var array $card
 */

$url = $this->Url->build("/system/$card[url]");
?>
<div class="d-flex flex-column bg-3 h-100 shadow">
    <a class="d-flex justify-content-center align-items-center p-5 bg-white" href="<?= $url ?>" style="height: 150px">
        <img class="mw-100 mh-100" src="<?= $this->apiHandler->getFileUrl($card['image_id'], 100, 70) ?>"
             alt="<?= $card['name'] ?>">
    </a>
    <div class="d-flex flex-column flex-fill p-4">
        <a class="h5 text-black text-decoration-none font-weight-bold" href="<?= $url ?>"><?= $card['name'] ?></a>
        <div class="d-flex flex-column py-3">
            <?php foreach ($card['tags'] as $tag): ?>
                <div class="d-flex">
                    <div style="width:20px; height: 20px" class="d-flex justify-content-center align-items-center mr-1">
                        <img class="mw-100 mh-100" src="<?= $this->apiHandler->getFileUrl($tag['image_id']) ?>">
                    </div>
                    <div>
                        <?php if ($tag['value']): ?>
                            <span class="text-primary font-weight-bold"><?= $tag['value'] ?></span>
                        <?php endif; ?>
                        <?= $tag['name'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="d-flex flex-column justify-content-around mt-auto">
            STARTING PRICE
            <h4 class="mb-3 font-weight-bold"><?= $this->Number->currency($card['price']) ?></h4>
            <a class="btn btn-primary text-nowrap" href="<?= $url ?>">Configure</a>
        </div>
    </div>
</div>

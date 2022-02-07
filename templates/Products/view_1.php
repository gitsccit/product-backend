<?php
/**
 * @var \App\View\AppView $this
 * @var \ProductBackend\Model\Entity\Product $product
 */
$this->Breadcrumbs->add($breadcrumbs ?? []);
?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-5">
            <?= $this->element('ProductBackend.galleries/1', ['images' => $product->gallery->gallery_images]) ?>
        </div>
        <div class="col-lg-4">
            <div class="d-flex flex-column justify-content-around">
                <h4 class="mb-3"><?= $product['name'] ?></h4>
                <?php if ($manufacturer = $product['manufacturer']) : ?>
                    <div class="mb-3">
                        <img src="<?= $filesApiHandler->getFileUrl($manufacturer['image_id'], 100, 70) ?>"
                             style="height: 60px">
                    </div>
                    <div>
                        <span class="text-muted"><?= "$manufacturer[name] part #:" ?></span>
                        <span class="text-primary"><?= $product['part_number'] ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-3">
            <?= $this->element('ProductBackend.cards/product_checkout', ['card' => $product]) ?>
        </div>
    </div>
</div>
<?php if ($product['show_related_systems'] && $product['related_systems']) : ?>
    <?= $this->element('ProductBackend.configured_systems', ['systems' => $product['related_systems']]) ?>
<?php endif; ?>
<div class="container py-4">
    <ul class="nav nav-tabs" id="product-nav-tab" role="tablist">
        <?php if ($product['description']) : ?>
            <li class="nav-item">
                <a class="nav-link text-black active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab">
                    Overview
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link text-black<?= $product['description'] ? '' : ' active' ?>"
               id="tech-specs-tab" data-bs-toggle="tab" href="#tech-specs" role="tab">Tech Specs</a>
        </li>
    </ul>
    <div class="tab-content py-3" id="product-content">
        <?php if ($description = $product['description']) : ?>
            <div class="tab-pane fade show active" id="overview"
                 role="tabpanel">
                <?= $description ?>
            </div>
        <?php endif; ?>
        <div class="tab-pane fade<?= $product['description'] ? '' : ' show active' ?>" id="tech-specs" role="tabpanel">
            <p>Specifications are provided by the manufacturer.</p>
            <?php foreach ($product['specification_groups'] as $groupName => $specificationGroup) : ?>
                <table class="table mb-0">
                    <colgroup>
                        <col class="w-25">
                    </colgroup>
                    <thead>
                    <tr>
                        <th scope="col" class="bg-black text-white"><?= $groupName ?></th>
                        <th scope="col" class="bg-black"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($specificationGroup as $specification) : ?>
                        <tr>
                            <td class="fw-bold"><?= $specification['name'] ?></td>
                            <td><?= $specification['text_value'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </div>
    </div>
</div>

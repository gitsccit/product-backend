<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>

<div class="modal-content bg-white p-3">
    <div class="d-flex justify-content-end">
        <a href="#close-modal" data-bs-dismiss="modal" aria-label="Close">
            <span class="bg-black text-white icon-cancel" aria-hidden="true"></span>
        </a>
    </div>
    <h1><?= $system['name'] ?></h1>
    <h3><?= $system['config_name'] ?></h3>
    <h3>Configured Price: <?= $this->Number->currency($system['unit_price']) ?></h3>
    <div class="mb-3">
        <img class="mw-100 mh-100" src="data:image/png;base64,<?= $banner ?>">
    </div>
    <?php foreach ($specificationGroups as $groupName => $specificationGroup) : ?>
        <table class="table table-bordered mb-0">
            <colgroup>
                <col class="w-25">
            </colgroup>
            <thead>
            <tr>
                <th scope="col" class="bg-black">
                    <div class="text-white"><?= $groupName ?></div>
                </th>
                <th scope="col" class="bg-black"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($specificationGroup as $bucketCategory => $specTypeSpecs) : ?>
                <?php if (is_assoc($specTypeSpecs)): ?>
                    <tr>
                        <td colspan="2" class="fw-bold bg-3"><?= $bucketCategory ?></td>
                    </tr>
                    <?php foreach ($specTypeSpecs as $type => $specs) : ?>
                        <tr>
                            <td><?= $type ?></td>
                            <td><?= implode('<br>', $specs) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td><?= $bucketCategory ?></td>
                        <td><?= implode('<br>', $specTypeSpecs) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
    <div class="d-flex justify-content-center my-3">Quotation Date: <?= $system['updated_at'] ?>. All prices subject to
        change.
    </div>
    <div class="row justify-content-center">
        <div class="col-3">
            <a class="w-100 btn btn-primary">Print</a>
        </div>
        <div class="col-3">
            <a class="w-100 btn btn-black" data-bs-dismiss="modal" aria-label="Close">Close</a>
        </div>
    </div>
</div>
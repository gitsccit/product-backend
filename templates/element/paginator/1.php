<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="item-group align-items-center py-1">
    <span class="text-nowrap"><?= $this->Paginator->counter(__('{{start}} - {{end}} of {{count}} Products')) ?></span>
    <ul class="pagination">
        <span class="fw-bold">View:&nbsp;</span>
        <?php foreach (['20', '50', '100'] as $pageSize): ?>
            <li class="<?= $pageSize === $this->request->getQuery('limit', '20') ? 'active' : '' ?>">
                <a href="<?= $this->Paginator->generateUrl(['limit' => $pageSize]) ?>">
                    <?= $pageSize ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <ul class="pagination ms-auto">
        <?= $this->Paginator->numbers(['modulus' => 2, 'first' => 1, 'last' => 1]) ?>
        <?= $this->Paginator->next( 'Next &#10095', ['escape' => false]) ?>
    </ul>
</div>

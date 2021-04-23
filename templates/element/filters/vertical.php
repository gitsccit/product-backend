<?php
/**
 * @var \App\View\AppView $this
 * @var array $filter
 * @var boolean $open
 */
$selectedOptions = json_decode(base64_decode($this->request->getQuery('filter', '')), true) ?? [];
?>
<div class="accordion">
    <input type="checkbox" id="filter-<?= $filter['name'] ?>" <?= $open ? 'checked' : '' ?>>
    <label class="accordion-label" for="filter-<?= $filter['name'] ?>">
        <?= $filter['name'] ?>
    </label>
    <div class="accordion-content">
        <?php foreach ($filter['options'] as $option): ?>
            <div class="my-1">
                <a href="<?= \Cake\Routing\Router::url($this->request->getPath() . '?filter=' . base64_encode(json_encode(array_replace($selectedOptions, [$filter['id'] => [$option['id'] => $option['name']]])))) ?>">
                    <?= $option['name'] ?>
                </a> <?= "($option[count])" ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

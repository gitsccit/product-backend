<?php
/**
 * @var \App\View\AppView $this
 * @var array $filters
 * @var boolean $open
 */
$selectedOptions = json_decode(base64_decode($this->request->getQuery('filter', '')), true) ?? [];
?>
<div class="h-100 bg-3 p-3">
    <span class="icon-sliders h4">Filter By:</span>
    <hr>
    <?php foreach ($filters as $index => $filter): ?>
        <?php $open = $index < 5; ?>
        <div class="accordion" id="#filter-accordion">
            <?php $open = $open || isset($newOptions[$filter['id']]); ?>
            <input type="checkbox" id="filter-<?= $filter['name'] ?>" <?= $open ? 'checked' : '' ?>>
            <label class="accordion-label bg-3 p-0 h5" for="filter-<?= $filter['name'] ?>">
                <?= $filter['name'] ?>
            </label>
            <div class="accordion-content">
                <?php foreach ($filter['options'] as $option): ?>
                    <?php
                    $newOptions = $selectedOptions;
                    $optionSelected = isset($newOptions[$filter['id']][$option['id']]);
                    if ($optionSelected) {
                        unset($newOptions[$filter['id']][$option['id']]);
                        if (empty($newOptions[$filter['id']])) {
                            unset($newOptions[$filter['id']]);
                        }
                    } else {
                        $newOptions = array_replace_recursive($newOptions,
                            [$filter['id'] => [$option['id'] => $option['name']]]);
                    }
                    $link = \Cake\Routing\Router::url($this->request->getPath());
                    if (!empty($newOptions)) {
                        $link .= '?filter=' . base64_encode(json_encode($newOptions));
                    }
                    ?>
                    <div class="d-flex align-items-center my-1">
                        <input class="me-2" type="checkbox" onclick="window.location.assign('<?= $link ?>')"
                            <?= $optionSelected ? ' checked' : '' ?>>
                        <span>
                            <?= "$option[name] ($option[count])" ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
        </div>
    <?php endforeach; ?>
</div>

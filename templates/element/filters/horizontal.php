<?php
/**
 * @var \App\View\AppView $this
 * @var array $tagCategories
 */
$selectedOptions = json_decode(base64_decode($this->request->getQuery('filter', '')), true) ?? [];
?>
<?= $this->Form->create(null, ['method' => 'GET']) ?>
<div class="row bg-secondary align-items-center p-3">
    <span class="text-white fw-bold">FILTER</span>
    <?php foreach ($tagCategories as $tagCategory): ?>
        <div class="col-2 px-2">
            <?php foreach ($tagCategory['tags'] as $tag): ?>
                <a href="<?= $this->Url->build([
                    'controller' => 'Systems',
                    'action' => implode('/', $this->request->getParam('pass')),
                    '?' => [
                        'filter' => base64_encode(json_encode(array_replace_recursive($selectedOptions, [$tagCategory['name'] => [$tag['id'] => $tag['name']]])))
                    ]
                ]) ?>"><?= "$tag[name] ($tag[count])" ?></a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->Form->end() ?>

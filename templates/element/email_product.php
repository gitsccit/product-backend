<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>

<div class="modal fade" id="email-a-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content bg-3 p-4">
            <div class="d-flex justify-content-end">
                <a href="#close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <span class="bg-black text-white icon-cancel" aria-hidden="true"></span>
                </a>
            </div>
            <h4 class="fw-bold mb-3">Email a link to this product</h4>
            <?= $this->Form->create(
                null,
                ['url' => ['controller' => 'Email', 'action' => 'product', 'plugin' => 'ProductBackend']]
            ); ?>
            <div class="mb-3">
                <?= $this->Form->control('name', ['required' => true, 'label' => 'Your Name']); ?>
            </div>
            <div class="mb-3">
                <?= $this->Form->control('email', ['type' => 'email', 'required' => true, 'label' => 'Your Email']); ?>
            </div>
            <div class="mb-3">
                <?= $this->Form->control('email2', ['type' => 'email', 'label' => 'Additional Email']); ?>
            </div>
            <div class="mb-3">
                <?= $this->Form->control('comments', ['type' => 'textarea']); ?>
            </div>
            <?= $this->Form->hidden('product_id', ['value' => $product->id]); ?>
            <div class="mb-3">
                <?= $this->element('ProductBackend.captcha'); ?>
            </div>
            <?= $this->Form->submit('Send Email', ['class' => 'btn btn-primary']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

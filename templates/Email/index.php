<?php
/**
 * @var \App\View\AppView $this
 * @var \ProductBackend\Model\Entity\Product $product
 */
?>

<div class="modal-content">
    <div class="modal-body">
        <div class="d-flex justify-content-end">
            <a href="#close-modal" data-bs-dismiss="modal" aria-label="Close">
                <span class="bg-black text-white icon-cancel" aria-hidden="true"></span>
            </a>
        </div>
        <h4 class="fw-bold mb-3">Email This <?= ucfirst($this->request->getParam('action')) ?></h4>
        <?= $this->Form->create(null); ?>
        <?= $this->Form->control('name', ['required' => true, 'label' => 'Your Name']); ?>
        <?= $this->Form->control('email', ['type' => 'email', 'required' => true, 'label' => 'Your Email']); ?>
        <?= $this->Form->control('email2', ['type' => 'email', 'label' => 'Additional Email']); ?>
        <?= $this->Form->control('comments', ['type' => 'textarea']); ?>
        <div class="mb-3">
            <?= $this->element('ProductBackend.captcha'); ?>
        </div>
        <?= $this->Form->submit('Send Email', ['class' => 'btn btn-primary']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>

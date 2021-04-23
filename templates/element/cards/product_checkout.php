<?php
/**
 * @var \App\View\AppView $this
 * @var array $card
 */
$this->Html->script('order', ['block' => true]);
?>

<?= $this->element('cart') ?>
<div class="p-4 bg-3 d-flex flex-column justify-content-between">
    <p class="h4 font-weight-bold mb-3"><?= $this->Number->currency($card['price']) ?></p>
    <div class="d-flex">
        <span class="font-weight-bold">Availability:&nbsp;</span>
        <p><?= $card['status'] ?></p>
    </div>
    <input class="form-control mr-3 mb-xl-0 mb-md-3" style="width: 4rem" type="number" name="quantity"
           min="1" value="1">
    <a class="btn btn-primary text-nowrap mt-3" href="#" onclick="add_to_order('products', <?= $card['id'] ?>)">Add To Order</a>
    <?= $this->element('email_product') ?>
    <a class="btn btn-primary text-nowrap mt-3" href="#email-a-product" data-toggle="modal"
       data-target="#email-a-product">Email</a>
</div>

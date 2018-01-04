<?php

global $woocommerce;
if($woocommerce->cart->cart_contents_count === 0) {
  $empty = ' ';
} else {
  $empty = 'd-none';
}
?>
<div class="cart-overlay">
  <div class="container">
    <div class="row">
      <div class="col text-left">
        <h2><a href="<?= wc_get_cart_url() ?>">Cart</a></h2>
      </div>
      <div class="col text-right">
        <div class="count">
          <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>
        </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-6 text-center">
      <div class="products" id="cart-overlay-products">
        <h4 class="<?= $empty ?>">Cart Is Empty</h4>
        <div class="products-wrapper">
          <?php foreach($woocommerce->cart->cart_contents as $item): ?>
            <?php
              $product = wc_get_product($item['product_id']);
            ?>
            <div class="product" id="cart-overlay-<?= $item['product_id'] ?>">
              <div class="product-image">
                <?= $product->get_image(); ?>
              </div>
              <div class="row">
                <div class="col product-details">
                  <span class="product-name"><?= $product->get_title(); ?></span>
                </div>
                <div class="col product-details">
                  <a href="#" class="remove-from-cart" data-product-id="<?= $item['product_id'] ?>">Remove from cart</a>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <span class="quantity"><?= $item['quantity']; ?></span> Case<?= $item['quantity'] > 1 ? 's' : '' ?>
                </div>
                <div class="col">
                  <a href="#add" class="ajax-change-quantity" data-dir="add" data-product-id="<?= $item['product_id'] ?>">+</a>
                  <a href="#subtract" class="ajax-change-quantity" data-dir="subtract" data-product-id="<?= $item['product_id'] ?>">-</a>
                </div>
              </div>
            </div>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="#" class="hide-cart-overlay">close</a>
    </div>
    <div class="col text-right">
      <a class="btn-checkout" href="<?= wc_get_checkout_url() ?>">Checkout</a>
    </div>
  </div>
</div>

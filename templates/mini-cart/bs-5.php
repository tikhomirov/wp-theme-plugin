<?php
/**
 *
 */
?>
<div class="navbar-nav mini-cart dropdown">
    <?php
    $cart_count = function_exists('WC') && !empty(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
    ?>
    <a id="dropdown-cart" class="cart-contents cart-link nav-link dropdown-toggle" href="<?php echo esc_url(wc_get_cart_url()); ?>"
       title="<?php esc_attr_e('View your shopping cart', 'understrap'); ?>" role="button"
       data-bs-toggle="dropdown" data-bs-boundary="viewport" data-bs-offset="0,8">
        <i class="las la-shopping-basket"></i>
        <span class="cart-count"><?php echo (int) $cart_count; ?></span>
    </a>

    <div class="dropdown-menu-mini-cart dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-cart">
        <div class="widget_shopping_cart_content">
            <?php
            if ($cart_count > 0) {
                woocommerce_mini_cart();
            } else {
                echo '<p class="woocommerce-mini-cart__empty-message">' . esc_html__('No products in the cart.', 'woocommerce') . '</p>';
            }
            ?>
        </div>
    </div>
</div>

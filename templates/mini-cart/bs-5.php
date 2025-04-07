<?php
/**
 *
 */
?>
<div class="navbar-nav mini-cart dropdown">
    <?php
    if (WC()->cart->get_cart_contents_count() > 0): ?>
        <a id="dropdown-cart" class="cart-contents cart-link nav-link dropdown-toggle" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'understrap'); ?>" role="button"
           data-bs-toggle="dropdown" >
            <i class="las la-shopping-basket"></i>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>

        <div class="dropdown-menu-mini-cart dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-cart">
            <div class="widget_shopping_cart_content">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>

    <?php
    endif; ?>
</div>

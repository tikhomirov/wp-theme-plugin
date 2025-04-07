<?php
/**
 *
 */
?>
<div class="nav-item dropdown mini-cart">
    <?php
    if (WC()->cart->get_cart_contents_count() > 0): ?>
        <a class="cart-contents cart-link nav-link dropdown-toggle" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'understrap'); ?>" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="true">
            <i class="las la-shopping-basket"></i>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-mini-cart">
            <div class="widget_shopping_cart_content">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>
    <?php
    endif; ?>
</div>

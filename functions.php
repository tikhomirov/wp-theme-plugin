<?php
/**
 * Simple functions
 */

use theme_plugin\components\Logger;
use theme_plugin\components\MenuCart;

function get_mini_cart(){
	return MenuCart::add_to_cart_fragments()['.mini-cart'] ?? '';
}

function get_mini_profile(){
	MenuCart::get_menu();
}

// redirect from 'checkout/thankyou.php'
add_action( 'woocommerce_before_template_part', function ( $name, $path, $located, $args ) {
	if ( 'checkout/thankyou.php' === $name ) {
		$order = $args['order'] instanceof WC_Order ? $args['order'] : null;
        if($order) {
            $query = http_build_query([
                'order_id' => $order->get_id(),
                'p_date'   => $order->get_date_paid(),
                'is_paid'  => $order->is_paid(), // retry check on endpoint
            ]);
            wp_safe_redirect('/?'.$query);
        }
	}
}, 10, 4 );


add_filter('login_headertext', function () {
    return get_bloginfo('name');
});

add_action('login_head', function () {
    ?>
    <style>
        #login h1 a {
            background-image: none;
            text-indent: 0;
            height: auto;
            width: auto;
        }
    </style>
    <?php
});

add_action('clean_menu_cache', 'clean_menu_cache');
function clean_menu_cache() {

}

if(!function_exists('dd')):
function dd(...$data)
{
    Logger::pre($data);
    wp_die();
}
endif;

if(!function_exists('dump')):
function dump(...$data)
{
    Logger::pre($data);
}
endif;
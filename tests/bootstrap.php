<?php

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

if (!defined('WP_THEME_PLUGIN')) {
    define('WP_THEME_PLUGIN', dirname(__DIR__) . '/wp-theme.php');
}

if (!function_exists('add_action')) {
    function add_action($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        return true;
    }
}

if (!function_exists('add_filter')) {
    function add_filter($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        return true;
    }
}

if (!function_exists('wp_enqueue_style')) {
    function wp_enqueue_style($handle, $src = '', $deps = [], $ver = false, $media = 'all')
    {
        return true;
    }
}

if (!function_exists('wp_enqueue_script')) {
    function wp_enqueue_script($handle, $src = '', $deps = [], $ver = false, $in_footer = false)
    {
        return true;
    }
}

if (!function_exists('plugin_dir_url')) {
    function plugin_dir_url($file)
    {
        return 'https://example.test/wp-content/plugins/wp-theme-plugin/';
    }
}

if (!function_exists('plugin_dir_path')) {
    function plugin_dir_path($file)
    {
        return dirname($file) . '/';
    }
}

if (!function_exists('esc_html__')) {
    function esc_html__($text, $domain = null)
    {
        return $text;
    }
}

if (!function_exists('esc_attr_e')) {
    function esc_attr_e($text, $domain = null)
    {
        echo $text;
    }
}

if (!function_exists('esc_url')) {
    function esc_url($url)
    {
        return $url;
    }
}

if (!function_exists('wc_get_cart_url')) {
    function wc_get_cart_url()
    {
        return '/cart/';
    }
}

if (!function_exists('woocommerce_mini_cart')) {
    function woocommerce_mini_cart()
    {
        echo '<ul class="woocommerce-mini-cart"><li class="mini_cart_item">Item</li></ul>';
    }
}

$GLOBALS['wp_theme_plugin_test_cart_count'] = 0;

if (!function_exists('WC')) {
    function WC()
    {
        return (object) [
            'cart' => new class {
                public function get_cart_contents_count()
                {
                    return (int) ($GLOBALS['wp_theme_plugin_test_cart_count'] ?? 0);
                }
            }
        ];
    }
}

require_once dirname(__DIR__) . '/components/class-menucart.php';

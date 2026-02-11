<?php
/**
 * Plugin Name:     WP Theme components plugin
 * Plugin URL:      https://rwsite.ru
 * Description:     Components for Bootstrap 5 framework WordPress themes with full WooCommerce support.
 * Version:         2.0.0
 * Text Domain:     wp-theme
 * Domain Path:     /languages
 * Author:          Aleksey Tikhomirov <alex@rwsite.ru>
 * Author URI:      https://rwsite.ru
 *
 * Tags:            theme feature, bootstrap 5, woocommerce
 * Requires at least: 5.6
 * Tested up to:     6.4
 * Requires PHP:     8.0
 */

namespace theme_plugin;

use theme_plugin\classes\MenuCache;
use theme_plugin\components\BootstrapMegaMenu;
use theme_plugin\components\GoogleFont;
use theme_plugin\components\IconFont;
use theme_plugin\components\Loader;
use theme_plugin\components\Logger;
use theme_plugin\components\MenuCart;
use theme_plugin\components\Progressbar;
use theme_plugin\components\ToTop;
use theme_plugin\src\Assets;
use theme_plugin\src\Woo\WooCommerce_Setup;
use theme_plugin\src\Admin\Admin_Page;

defined('ABSPATH') || die();

define('WP_THEME_PLUGIN', __FILE__);

/**
 * WordPress Autoload classes.
 */
spl_autoload_register(function ($full_class_name) {
    if (strpos($full_class_name, __NAMESPACE__) !== 0) {
        return;
    }
    $class_parts = explode('\\', $full_class_name);
    unset($class_parts[0]); // Unset the __NAMESPACE__.

    $class_name = array_pop($class_parts);
    $class_file = 'class-'.strtolower(str_replace('_', '-', $class_name)).'.php';

    $file_path = plugin_dir_path(__FILE__).implode(DIRECTORY_SEPARATOR, $class_parts).DIRECTORY_SEPARATOR.$class_file;

    if (file_exists($file_path)) {
        require_once $file_path;
    }
});

require_once 'functions.php';

Logger::$logPath = plugin_dir_path(__FILE__).'log.log';
MenuCart::$template = 'bs-5';


/**
 * Run list of features
 */
add_action('init', function () {

    // Assets - Bootstrap 5 CSS/JS and theme styles
    (new Assets())->add_actions();

    // WooCommerce Bootstrap 5 integration
    (new WooCommerce_Setup())->add_actions();

    // Admin settings page
    if (is_admin()) {
        (new Admin_Page())->add_actions();
    }

    // К этому скрипту подключаются все остальные inline css компоненты
    add_action('wp_enqueue_scripts', function () {
        wp_enqueue_style('wp-theme', plugin_dir_url(__FILE__).'assets/css/style.css', ['bootstrap'], '2.0.0');
    }, 10);

    // page loader
    (new Loader())->add_actions();

    // Google font support
    (new GoogleFont())->add_actions();
    (new IconFont('simple-line-icons'))->add_actions();

    // menu cart
    (new MenuCart())->add_action();

    // to top button
    (new ToTop())->add_actions();

    // post load progress bar
    (new Progressbar())->add_actions();

    // Bootstrap dropdown menu feature/fix. do_action( 'print_menu' );
    // required wp-custom-sidebar-plugin
    (new BootstrapMegaMenu())->add_actions();

    // Menu html cache in option for BootstrapNavWalker. Unused now
    (new MenuCache())->add_actions();
});

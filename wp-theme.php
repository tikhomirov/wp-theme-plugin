<?php
/**
 * Plugin Name:     WP Theme components plugin
 * Plugin URL:      https://rwsite.ru
 * Description:     Components for Bootstrap 5 framework WordPress themes.
 * Version:         1.0.4
 * Text Domain:     wp-theme
 * Domain Path:     /languages
 * Author:          Aleksey Tikhomirov <alex@rwsite.ru>
 * Author URI:      https://rwsite.ru
 *
 * Tags:            theme feature
 * Requires at least: 5.6
 * Tested up to:    5.9.0
 * Requires PHP:    8.0+
 */

namespace theme_plugin;

use theme_plugin\classes\MenuCache;
use theme_plugin\components\BootstrapMegaMenu;
use theme_plugin\components\GoogleFont;
use theme_plugin\components\IconFont;
use theme_plugin\components\Loader;
use theme_plugin\components\Logger;
use theme_plugin\components\MenuCart;
use theme_plugin\components\MenuField;
use theme_plugin\components\Modal;
use theme_plugin\components\Progressbar;
use theme_plugin\components\ToTop;

defined('ABSPATH') || die();

define('WP_THEME_PLUGIN', __FILE__);

/**
 * WordPress Autoload classes.
 */
spl_autoload_register(function ($full_class_name) {
    if (strpos($full_class_name, __NAMESPACE__) !== 0) {
        return;
    }
    $full_class_name = strtolower(str_replace('_', '-', $full_class_name));
    $class_parts = explode('\\', $full_class_name);
    unset($class_parts[0]); // Unset the __NAMESPACE__.

    $class_file = 'class-'.array_pop($class_parts).'.php';
    $class_parts[] = $class_file;

    if (file_exists(plugin_dir_path(__FILE__).implode(DIRECTORY_SEPARATOR, $class_parts))) {
        require_once plugin_dir_path(__FILE__).implode(DIRECTORY_SEPARATOR, $class_parts);
    } else {
        echo 'FATAL ERROR: File not found by path: ';
        echo '<pre>';
        var_dump(plugin_dir_path(__FILE__).implode(DIRECTORY_SEPARATOR, $class_parts));
        echo '</pre>';
        die();
    }
});

require_once 'functions.php';

Logger::$logPath = plugin_dir_path(__FILE__).'log.log';
MenuCart::$template = 'bs-5';


/**
 * Run list of features
 */
add_action('init', function () {

    // К этому скрипту подключаются все остальные inline css компоненты
    add_action('wp_enqueue_scripts', function () {
       wp_enqueue_style('wp-theme', plugin_dir_url(__FILE__).'assets/css/style.css', [], '1.0.0');
    }, 1);

    // Modal windows example
    // (new Modal())->add_actions();

    // MegaMenu admin component. dev
    // (new MenuField())->add_actions();

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
    (new BootstrapMegaMenu())->add_actions();

    // Menu html cache in option for BootstrapNavWalker. Unused now
    (new MenuCache())->add_actions();

});

<?php
/**
 * Plugin Name:     WP Theme plugin
 * Plugin URL:      https://rwsite.ru
 * Description:     WP Theme plugin
 * Version:         1.0.0
 * Text Domain:     wp-theme
 * Domain Path:     /languages
 * Author:          Aleksey Tikhomirov <alex@rwsite.ru>
 * Author URI:      https://rwsite.ru
 *
 * Tags:            theme feature
 * Requires at least: 4.6
 * Tested up to:    5.8.0
 * Requires PHP:    8.0+
 */

namespace theme_plugin;

use theme_plugin\components\GoogleFont;
use theme_plugin\components\Loader;
use theme_plugin\components\MenuCart;
use theme_plugin\components\Modal;
use theme_plugin\components\Panel;
use theme_plugin\components\Progressbar;
use theme_plugin\components\ToTop;

defined('ABSPATH') || die();

define('WP_THEME_PLUGIN', __FILE__);

/**
 * WordPress Autoload classes.
 */
spl_autoload_register( function ( $full_class_name ) {
    if ( strpos( $full_class_name, __NAMESPACE__  ) !== 0 ) {
        return;
    }
    $full_class_name = strtolower( str_replace( '_', '-', $full_class_name ) );
    $class_parts     = explode( '\\', $full_class_name );
    unset( $class_parts[0] ); // Unset the __NAMESPACE__.

    $class_file    = 'class-' . array_pop( $class_parts ) . '.php';
    $class_parts[] = $class_file;

    require_once plugin_dir_path( __FILE__ ) . implode( DIRECTORY_SEPARATOR, $class_parts );
} );


require_once 'functions.php';

(new Loader())->add_actions();
//(new Modal())->add_actions();
(new GoogleFont())->add_actions();
MenuCart::$template = 'bs-5';
(new MenuCart())->add_action();
(new Panel())->add_actions();
(new ToTop())->add_actions();
(new Progressbar())->add_actions();

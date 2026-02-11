<?php
/**
 * Woocommerce cart in menu
 */

namespace theme_plugin\components;

/**
 * Class WC_theme
 */
class MenuCart
{
    public static string $template = 'bs-4';
    public $file;
    public $url;
    public $font;
    public $assets;
    public $ver;
    public $dir;
    public $theme;

    /**
     * Add actions
     */
    public function __construct()
    {
        foreach (static::get_env() as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function get_env($name = null)
    {
        $file = WP_THEME_PLUGIN;
        $url = plugin_dir_url($file);
        $assets = $url.'assets';
        $ver = defined('WP_DEBUG') && WP_DEBUG ? time() : '1.0';

        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            $mini_cart_css = plugin_dir_path($file) . 'assets/css/mini-cart.css';
            $mini_cart_js = plugin_dir_path($file) . 'assets/js/mini-cart-ajax.js';

            $css_mtime = file_exists($mini_cart_css) ? filemtime($mini_cart_css) : null;
            $js_mtime = file_exists($mini_cart_js) ? filemtime($mini_cart_js) : null;

            if (null !== $css_mtime || null !== $js_mtime) {
                $ver = (string) max((int) $css_mtime, (int) $js_mtime);
            }
        }
        $dir = plugin_dir_path($file);
        $theme = static::$template;

        $args = compact('file', 'url', 'assets', 'ver', 'dir', 'theme');
        if (!empty($args[$name])) {
            return $args[$name];
        }

        return $args;
    }

    /**
     * Change cart in page header
     *
     * @param  null|array  $fragments
     * @return array
     */
    public static function add_to_cart_fragments($fragments = null)
    {
        if (!function_exists('WC') || empty(WC()->cart)) {
            return $fragments;
        }

        if (!is_array($fragments)) {
            $fragments = [];
        }

        // Обновляем счетчик товаров
        $cart_count = WC()->cart->get_cart_contents_count();
        $fragments['.cart-count'] = '<span class="cart-count">' . $cart_count . '</span>';

        $fragments['.mini-cart'] = static::render_mini_cart();

        return $fragments;
    }

    private static function render_mini_cart(): string
    {
        $dir = static::get_env('dir');
        $theme = static::get_env('theme');
        $template_path = rtrim($dir, '/\\') . '/templates/mini-cart/' . $theme . '.php';

        ob_start();

        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo '<div class="navbar-nav mini-cart dropdown">';
            echo '<span class="cart-count">' . (function_exists('WC') && !empty(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0) . '</span>';
            echo '</div>';
        }

        return (string) ob_get_clean();
    }

    public static function get_menu()
    {
        // if(is_user_logged_in()):endif;
        ?>
        <div class="nav-item mini-profile">
            <a class="menu-item nav-link" href="<?= wc_get_page_permalink('myaccount') ?>"
               style="padding: 0 10px; line-height: 1;">
                <i class="las la-user-circle"></i>
            </a>
        </div>
        <?php
    }

    public function add_action()
    {
        add_filter('woocommerce_add_to_cart_fragments', [self::class, 'add_to_cart_fragments'], 10, 1);
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('wp-theme-cart', $this->assets.'/css/mini-cart.css', false, $this->ver);
            
            // Подключаем JavaScript для AJAX обновлений
            wp_enqueue_script(
                'wp-theme-cart-ajax', 
                $this->assets.'/js/mini-cart-ajax.js', 
                ['jquery'], 
                $this->ver, 
                true
            );
        });
    }
}
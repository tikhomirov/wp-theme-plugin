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

	/**
	 * Add actions
	 */
	public function __construct() {
        foreach (static::get_env() as $key => $value){
            $this->$key = $value;
        }
	}

    public static function get_env($name = null)
    {
        $file = WP_THEME_PLUGIN;
        $url = plugin_dir_url($file);
        $assets = $url . 'assets';
        $ver = defined('WP_DEBUG') && WP_DEBUG ? time() : '1.0';
        $dir = plugin_dir_path($file);
        $theme = static::$template;

        $args = compact('file', 'url', 'assets', 'ver', 'dir', 'theme');
        if(!empty($args[$name])){
            return $args[$name];
        }

        return $args;
    }

    public function add_action()
    {
        add_filter( 'woocommerce_add_to_cart_fragments', [ self::class, 'add_to_cart_fragments' ], 10, 1 );
        add_action('wp_enqueue_scripts', function (){
            wp_enqueue_style('wp-theme-cart',$this->assets . '/css/mini-cart.css', false, $this->ver);
        });
    }

    /**
     * Change cart in page header
     *
     * @param null|array $fragments
     * @return array
     */
    public static function add_to_cart_fragments($fragments = null)
    {
        if (!function_exists('WC')) {
            return $fragments;
        }

        if (WC()->cart->get_cart_contents_count() > 0) {
            $fragments['.mini-cart'] = load_template( self::get_env('dir') .'templates/mini-cart/'. self::get_env('theme') . '.php', false, compact('fragments' ) );
        } else {
            $fragments['.mini-cart'] = '<div class="dropdown mini-cart"></div>';
        }

        return $fragments;
    }

    public static function get_menu(){
        if(is_user_logged_in()):
        ?>
        <div class="nav-item">
            <a class="menu-item nav-link" href="/my-account" style="padding: 0 10px; line-height: 1;">
                <i class="las la-user-circle"></i>
            </a>
        </div>
        <?php endif;
    }
}
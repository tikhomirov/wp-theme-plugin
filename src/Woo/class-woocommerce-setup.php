<?php
/**
 * WooCommerce Bootstrap 5 integration
 *
 * @package theme_plugin
 */

namespace theme_plugin\src\Woo;

defined('ABSPATH') || exit;

/**
 * WooCommerce Setup class
 *
 * Handles all WooCommerce hooks and Bootstrap 5 integration.
 */
class WooCommerce_Setup
{
    /**
     * Initialize WooCommerce hooks
     */
    public function add_actions(): void
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        // Product loop columns
        add_filter('loop_shop_columns', [$this, 'loop_columns']);
        add_filter('woocommerce_product_thumbnails_columns', [$this, 'thumbnail_columns']);

        // Products per page
        add_filter('loop_shop_per_page', [$this, 'products_per_page']);

        // Related products
        add_filter('woocommerce_output_related_products_args', [$this, 'related_products_args']);

        // Breadcrumbs
        add_filter('woocommerce_breadcrumb_defaults', [$this, 'breadcrumb_defaults']);

        // Pagination
        add_filter('woocommerce_pagination_args', [$this, 'pagination_args']);

        // Notices - convert to Bootstrap alerts
        add_filter('woocommerce_demo_store', [$this, 'demo_store_notice'], 10, 2);

        // Single product tabs
        add_filter('woocommerce_product_tabs', [$this, 'product_tabs_classes'], 98);

        // Cart page
        add_action('woocommerce_before_cart', [$this, 'cart_wrapper_start']);
        add_action('woocommerce_after_cart', [$this, 'cart_wrapper_end']);

        // Checkout page
        add_action('woocommerce_before_checkout_form', [$this, 'checkout_wrapper_start'], 5);
        add_action('woocommerce_after_checkout_form', [$this, 'checkout_wrapper_end'], 99);

        // My Account page
        add_filter('woocommerce_account_menu_items', [$this, 'account_menu_items']);

        // Product gallery - ensure zoom/lightbox work
        add_action('wp_enqueue_scripts', [$this, 'enqueue_gallery_scripts']);

        // Quantity input buttons
        add_action('wp_footer', [$this, 'quantity_buttons_script']);
    }

    /**
     * Set number of products per row
     */
    public function loop_columns(): int
    {
        $settings = get_option('wp_theme_settings', []);
        return (int) ($settings['products_per_row'] ?? 4);
    }

    /**
     * Set number of thumbnail columns
     */
    public function thumbnail_columns(): int
    {
        return 4;
    }

    /**
     * Set products per page
     */
    public function products_per_page(): int
    {
        $settings = get_option('wp_theme_settings', []);
        return (int) ($settings['products_per_page'] ?? 12);
    }

    /**
     * Related products args
     */
    public function related_products_args(array $args): array
    {
        $args['posts_per_page'] = 4;
        $args['columns'] = 4;
        return $args;
    }

    /**
     * Bootstrap 5 breadcrumb defaults
     */
    public function breadcrumb_defaults(array $defaults): array
    {
        return [
            'delimiter'   => '',
            'wrap_before' => '<nav aria-label="breadcrumb"><ol class="breadcrumb">',
            'wrap_after'  => '</ol></nav>',
            'before'      => '<li class="breadcrumb-item">',
            'after'       => '</li>',
            'home'        => _x('Home', 'breadcrumb', 'wp-theme'),
        ];
    }

    /**
     * Bootstrap 5 pagination args
     */
    public function pagination_args(array $args): array
    {
        $args['prev_text'] = '<span aria-hidden="true">&laquo;</span>';
        $args['next_text'] = '<span aria-hidden="true">&raquo;</span>';
        $args['type'] = 'list';
        return $args;
    }

    /**
     * Demo store notice with Bootstrap alert
     */
    public function demo_store_notice(string $notice, string $notice_text): string
    {
        return '<div class="alert alert-info alert-dismissible fade show woocommerce-store-notice" role="alert">'
            . wp_kses_post($notice_text)
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            . '</div>';
    }

    /**
     * Add Bootstrap classes to product tabs
     */
    public function product_tabs_classes(array $tabs): array
    {
        // Tabs will be styled via CSS, no modification needed here
        return $tabs;
    }

    /**
     * Cart wrapper start
     */
    public function cart_wrapper_start(): void
    {
        echo '<div class="woocommerce-cart-wrapper">';
    }

    /**
     * Cart wrapper end
     */
    public function cart_wrapper_end(): void
    {
        echo '</div>';
    }

    /**
     * Checkout wrapper start
     */
    public function checkout_wrapper_start(): void
    {
        echo '<div class="woocommerce-checkout-wrapper">';
    }

    /**
     * Checkout wrapper end
     */
    public function checkout_wrapper_end(): void
    {
        echo '</div>';
    }

    /**
     * Account menu items
     */
    public function account_menu_items(array $items): array
    {
        // Keep default items, styling handled via CSS
        return $items;
    }

    /**
     * Enqueue gallery scripts
     */
    public function enqueue_gallery_scripts(): void
    {
        if (is_product()) {
            wp_enqueue_script('flexslider');
            wp_enqueue_script('zoom');
            wp_enqueue_script('photoswipe-ui-default');
            wp_enqueue_style('photoswipe-default-skin');
        }
    }

    /**
     * Quantity input +/- buttons script
     */
    public function quantity_buttons_script(): void
    {
        if (!is_cart() && !is_product()) {
            return;
        }
        ?>
        <script>
        jQuery(function($) {
            // Add +/- buttons to quantity inputs
            $(document).on('click', '.qty-btn', function(e) {
                e.preventDefault();
                var $input = $(this).siblings('.qty');
                var currentVal = parseFloat($input.val()) || 0;
                var max = parseFloat($input.attr('max')) || 9999;
                var min = parseFloat($input.attr('min')) || 0;
                var step = parseFloat($input.attr('step')) || 1;

                if ($(this).hasClass('qty-plus')) {
                    if (currentVal < max) {
                        $input.val(currentVal + step).trigger('change');
                    }
                } else {
                    if (currentVal > min) {
                        $input.val(currentVal - step).trigger('change');
                    }
                }
            });

            // Wrap quantity inputs with buttons
            function wrapQuantityInputs() {
                $('.quantity:not(.buttons-added)').each(function() {
                    var $qty = $(this).find('.qty');
                    if ($qty.length && !$(this).hasClass('buttons-added')) {
                        $(this).addClass('buttons-added input-group');
                        $qty.before('<button type="button" class="btn btn-outline-secondary qty-btn qty-minus">-</button>');
                        $qty.after('<button type="button" class="btn btn-outline-secondary qty-btn qty-plus">+</button>');
                    }
                });
            }

            wrapQuantityInputs();
            $(document.body).on('updated_cart_totals', wrapQuantityInputs);
        });
        </script>
        <?php
    }
}

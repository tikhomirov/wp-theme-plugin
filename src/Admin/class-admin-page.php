<?php
/**
 * Theme Settings Admin Page
 *
 * @package theme_plugin
 */

namespace theme_plugin\src\Admin;

defined('ABSPATH') || exit;

/**
 * Admin Page class
 *
 * Handles theme settings page in WordPress admin.
 */
class Admin_Page
{
    /**
     * Option name for settings
     */
    private const OPTION_NAME = 'wp_theme_settings';

    /**
     * Plugin URL
     */
    private string $url;

    /**
     * Plugin path
     */
    private string $path;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->url = plugin_dir_url(WP_THEME_PLUGIN);
        $this->path = plugin_dir_path(WP_THEME_PLUGIN);
    }

    /**
     * Initialize admin hooks
     */
    public function add_actions(): void
    {
        add_action('admin_menu', [$this, 'add_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    /**
     * Add menu page
     */
    public function add_menu_page(): void
    {
        add_menu_page(
            __('Theme Settings', 'wp-theme'),
            __('Theme Settings', 'wp-theme'),
            'manage_options',
            'wp-theme-settings',
            [$this, 'render_settings_page'],
            'dashicons-admin-customizer',
            61
        );
    }

    /**
     * Register settings
     */
    public function register_settings(): void
    {
        register_setting(
            'wp_theme_settings_group',
            self::OPTION_NAME,
            [
                'type' => 'array',
                'sanitize_callback' => [$this, 'sanitize_settings'],
                'default' => $this->get_defaults(),
            ]
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets(string $hook): void
    {
        if ('toplevel_page_wp-theme-settings' !== $hook) {
            return;
        }

        // WordPress color picker
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        // WP Field library
        $wp_field_path = $this->path . 'lib/wp-field/WP_Field.php';
        if (file_exists($wp_field_path)) {
            require_once $wp_field_path;
        }

        // Admin styles
        wp_enqueue_style(
            'wp-theme-admin',
            $this->url . 'assets/css/admin.css',
            [],
            '2.0.0'
        );

        // Admin script
        wp_enqueue_script(
            'wp-theme-admin',
            $this->url . 'assets/js/admin.js',
            ['jquery', 'wp-color-picker'],
            '2.0.0',
            true
        );
    }

    /**
     * Get default settings
     */
    private function get_defaults(): array
    {
        return [
            // Colors
            'primary_color' => '#0d6efd',
            'secondary_color' => '#6c757d',
            'success_color' => '#198754',
            'danger_color' => '#dc3545',
            'warning_color' => '#ffc107',
            'info_color' => '#0dcaf0',
            'light_color' => '#f8f9fa',
            'dark_color' => '#212529',
            // Typography
            'body_font' => 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
            'heading_font' => '',
            'base_font_size' => '16px',
            // Layout
            'border_radius' => '0.375rem',
            // Header
            'header_style' => 'default',
            'header_bg_color' => '#0d6efd',
            'header_text_color' => '#ffffff',
            'header_sticky' => 'yes',
            'show_search' => 'yes',
            'show_cart' => 'yes',
            // Footer
            'footer_columns' => '4',
            'footer_bg_color' => '#212529',
            'footer_text_color' => '#f8f9fa',
            'footer_copyright' => '',
            'show_social_links' => 'yes',
            // WooCommerce
            'products_per_row' => '4',
            'products_per_page' => '12',
            'show_sale_badge' => 'yes',
            'show_rating' => 'yes',
            'cart_icon_style' => 'bag',
        ];
    }

    /**
     * Sanitize settings
     */
    public function sanitize_settings(array $input): array
    {
        $sanitized = [];
        $defaults = $this->get_defaults();

        // Colors
        $color_fields = ['primary_color', 'secondary_color', 'success_color', 'danger_color', 'warning_color', 'info_color', 'light_color', 'dark_color', 'header_bg_color', 'header_text_color', 'footer_bg_color', 'footer_text_color'];
        foreach ($color_fields as $field) {
            $sanitized[$field] = sanitize_hex_color($input[$field] ?? $defaults[$field]);
        }

        // Text/Select fields
        $text_fields = ['body_font', 'heading_font', 'base_font_size', 'border_radius', 'header_style', 'header_sticky', 'show_search', 'show_cart', 'footer_columns', 'show_social_links', 'products_per_row', 'products_per_page', 'show_sale_badge', 'show_rating', 'cart_icon_style'];
        foreach ($text_fields as $field) {
            $sanitized[$field] = sanitize_text_field($input[$field] ?? $defaults[$field]);
        }

        // Textarea fields
        $sanitized['footer_copyright'] = wp_kses_post($input['footer_copyright'] ?? $defaults['footer_copyright']);

        return $sanitized;
    }

    /**
     * Get settings sections
     */
    private function get_sections(): array
    {
        return [
            'colors' => [
                'title' => __('Colors', 'wp-theme'),
                'icon' => 'dashicons-art',
                'fields' => $this->get_color_fields(),
            ],
            'typography' => [
                'title' => __('Typography', 'wp-theme'),
                'icon' => 'dashicons-editor-textcolor',
                'fields' => $this->get_typography_fields(),
            ],
            'header' => [
                'title' => __('Header', 'wp-theme'),
                'icon' => 'dashicons-menu-alt3',
                'fields' => $this->get_header_fields(),
            ],
            'footer' => [
                'title' => __('Footer', 'wp-theme'),
                'icon' => 'dashicons-editor-insertmore',
                'fields' => $this->get_footer_fields(),
            ],
            'woocommerce' => [
                'title' => __('WooCommerce', 'wp-theme'),
                'icon' => 'dashicons-cart',
                'fields' => $this->get_woocommerce_fields(),
            ],
            'layout' => [
                'title' => __('Layout', 'wp-theme'),
                'icon' => 'dashicons-layout',
                'fields' => $this->get_layout_fields(),
            ],
        ];
    }

    /**
     * Get color fields
     */
    private function get_color_fields(): array
    {
        return [
            [
                'id' => 'primary_color',
                'type' => 'color',
                'label' => __('Primary Color', 'wp-theme'),
                'desc' => __('Main brand color used for buttons, links, etc.', 'wp-theme'),
            ],
            [
                'id' => 'secondary_color',
                'type' => 'color',
                'label' => __('Secondary Color', 'wp-theme'),
                'desc' => __('Secondary brand color.', 'wp-theme'),
            ],
            [
                'id' => 'success_color',
                'type' => 'color',
                'label' => __('Success Color', 'wp-theme'),
                'desc' => __('Color for success messages and states.', 'wp-theme'),
            ],
            [
                'id' => 'danger_color',
                'type' => 'color',
                'label' => __('Danger Color', 'wp-theme'),
                'desc' => __('Color for error messages and states.', 'wp-theme'),
            ],
            [
                'id' => 'warning_color',
                'type' => 'color',
                'label' => __('Warning Color', 'wp-theme'),
                'desc' => __('Color for warning messages.', 'wp-theme'),
            ],
            [
                'id' => 'info_color',
                'type' => 'color',
                'label' => __('Info Color', 'wp-theme'),
                'desc' => __('Color for informational messages.', 'wp-theme'),
            ],
        ];
    }

    /**
     * Get typography fields
     */
    private function get_typography_fields(): array
    {
        return [
            [
                'id' => 'body_font',
                'type' => 'select',
                'label' => __('Body Font', 'wp-theme'),
                'desc' => __('Font family for body text.', 'wp-theme'),
                'options' => [
                    'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif' => 'System Default',
                    '"Open Sans", sans-serif' => 'Open Sans',
                    '"Roboto", sans-serif' => 'Roboto',
                    '"Lato", sans-serif' => 'Lato',
                    '"Montserrat", sans-serif' => 'Montserrat',
                    '"Nunito", sans-serif' => 'Nunito',
                ],
            ],
            [
                'id' => 'heading_font',
                'type' => 'select',
                'label' => __('Heading Font', 'wp-theme'),
                'desc' => __('Font family for headings. Leave empty to use body font.', 'wp-theme'),
                'options' => [
                    '' => 'Same as body',
                    '"Playfair Display", serif' => 'Playfair Display',
                    '"Merriweather", serif' => 'Merriweather',
                    '"Oswald", sans-serif' => 'Oswald',
                    '"Raleway", sans-serif' => 'Raleway',
                ],
            ],
            [
                'id' => 'base_font_size',
                'type' => 'select',
                'label' => __('Base Font Size', 'wp-theme'),
                'desc' => __('Base font size for body text.', 'wp-theme'),
                'options' => [
                    '14px' => '14px',
                    '15px' => '15px',
                    '16px' => '16px (default)',
                    '17px' => '17px',
                    '18px' => '18px',
                ],
            ],
        ];
    }

    /**
     * Get layout fields
     */
    private function get_layout_fields(): array
    {
        return [
            [
                'id' => 'border_radius',
                'type' => 'select',
                'label' => __('Border Radius', 'wp-theme'),
                'desc' => __('Border radius for buttons, cards, inputs.', 'wp-theme'),
                'options' => [
                    '0' => 'None (square)',
                    '0.25rem' => 'Small',
                    '0.375rem' => 'Default',
                    '0.5rem' => 'Medium',
                    '1rem' => 'Large',
                    '50rem' => 'Pill',
                ],
            ],
        ];
    }

    /**
     * Get header fields
     */
    private function get_header_fields(): array
    {
        return [
            [
                'id' => 'header_style',
                'type' => 'select',
                'label' => __('Header Style', 'wp-theme'),
                'desc' => __('Choose header layout style.', 'wp-theme'),
                'options' => [
                    'default' => __('Default (Logo left, menu right)', 'wp-theme'),
                    'centered' => __('Centered (Logo center, menu below)', 'wp-theme'),
                    'minimal' => __('Minimal (Logo only, hamburger menu)', 'wp-theme'),
                ],
            ],
            [
                'id' => 'header_bg_color',
                'type' => 'color',
                'label' => __('Header Background Color', 'wp-theme'),
                'desc' => __('Background color for the header/navbar.', 'wp-theme'),
            ],
            [
                'id' => 'header_text_color',
                'type' => 'color',
                'label' => __('Header Text Color', 'wp-theme'),
                'desc' => __('Text and link color in the header.', 'wp-theme'),
            ],
            [
                'id' => 'header_sticky',
                'type' => 'select',
                'label' => __('Sticky Header', 'wp-theme'),
                'desc' => __('Keep header fixed at top when scrolling.', 'wp-theme'),
                'options' => [
                    'yes' => __('Yes', 'wp-theme'),
                    'no' => __('No', 'wp-theme'),
                ],
            ],
            [
                'id' => 'show_search',
                'type' => 'select',
                'label' => __('Show Search', 'wp-theme'),
                'desc' => __('Display search icon in header.', 'wp-theme'),
                'options' => [
                    'yes' => __('Yes', 'wp-theme'),
                    'no' => __('No', 'wp-theme'),
                ],
            ],
            [
                'id' => 'show_cart',
                'type' => 'select',
                'label' => __('Show Cart Icon', 'wp-theme'),
                'desc' => __('Display mini cart icon in header.', 'wp-theme'),
                'options' => [
                    'yes' => __('Yes', 'wp-theme'),
                    'no' => __('No', 'wp-theme'),
                ],
            ],
        ];
    }

    /**
     * Get footer fields
     */
    private function get_footer_fields(): array
    {
        return [
            [
                'id' => 'footer_columns',
                'type' => 'select',
                'label' => __('Footer Columns', 'wp-theme'),
                'desc' => __('Number of widget columns in footer.', 'wp-theme'),
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
            ],
            [
                'id' => 'footer_bg_color',
                'type' => 'color',
                'label' => __('Footer Background Color', 'wp-theme'),
                'desc' => __('Background color for the footer.', 'wp-theme'),
            ],
            [
                'id' => 'footer_text_color',
                'type' => 'color',
                'label' => __('Footer Text Color', 'wp-theme'),
                'desc' => __('Text color in the footer.', 'wp-theme'),
            ],
            [
                'id' => 'footer_copyright',
                'type' => 'textarea',
                'label' => __('Copyright Text', 'wp-theme'),
                'desc' => __('Custom copyright text. Use {year} for current year, {site} for site name.', 'wp-theme'),
            ],
            [
                'id' => 'show_social_links',
                'type' => 'select',
                'label' => __('Show Social Links', 'wp-theme'),
                'desc' => __('Display social media icons in footer.', 'wp-theme'),
                'options' => [
                    'yes' => __('Yes', 'wp-theme'),
                    'no' => __('No', 'wp-theme'),
                ],
            ],
        ];
    }

    /**
     * Get WooCommerce fields
     */
    private function get_woocommerce_fields(): array
    {
        return [
            [
                'id' => 'products_per_row',
                'type' => 'select',
                'label' => __('Products Per Row', 'wp-theme'),
                'desc' => __('Number of products per row on shop page.', 'wp-theme'),
                'options' => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
            ],
            [
                'id' => 'products_per_page',
                'type' => 'select',
                'label' => __('Products Per Page', 'wp-theme'),
                'desc' => __('Number of products to show per page.', 'wp-theme'),
                'options' => [
                    '8' => '8',
                    '12' => '12',
                    '16' => '16',
                    '20' => '20',
                    '24' => '24',
                ],
            ],
            [
                'id' => 'show_sale_badge',
                'type' => 'select',
                'label' => __('Show Sale Badge', 'wp-theme'),
                'desc' => __('Display sale badge on discounted products.', 'wp-theme'),
                'options' => [
                    'yes' => __('Yes', 'wp-theme'),
                    'no' => __('No', 'wp-theme'),
                ],
            ],
            [
                'id' => 'show_rating',
                'type' => 'select',
                'label' => __('Show Rating', 'wp-theme'),
                'desc' => __('Display star rating on product cards.', 'wp-theme'),
                'options' => [
                    'yes' => __('Yes', 'wp-theme'),
                    'no' => __('No', 'wp-theme'),
                ],
            ],
            [
                'id' => 'cart_icon_style',
                'type' => 'select',
                'label' => __('Cart Icon Style', 'wp-theme'),
                'desc' => __('Style of cart icon in header.', 'wp-theme'),
                'options' => [
                    'bag' => __('Shopping Bag', 'wp-theme'),
                    'cart' => __('Shopping Cart', 'wp-theme'),
                    'basket' => __('Basket', 'wp-theme'),
                ],
            ],
        ];
    }

    /**
     * Render settings page
     */
    public function render_settings_page(): void
    {
        $settings = get_option(self::OPTION_NAME, $this->get_defaults());
        $sections = $this->get_sections();
        $active_section = isset($_GET['section']) ? sanitize_key($_GET['section']) : 'colors';

        // Include WP_Field if available
        $wp_field_path = $this->path . 'lib/wp-field/WP_Field.php';
        if (file_exists($wp_field_path) && !class_exists('WP_Field')) {
            require_once $wp_field_path;
        }
        ?>
        <div class="wrap wp-theme-settings-wrap">
            <h1><?php esc_html_e('Theme Settings', 'wp-theme'); ?></h1>

            <div class="wp-theme-settings-container">
                <nav class="wp-theme-settings-nav">
                    <ul>
                        <?php foreach ($sections as $section_id => $section) : ?>
                            <li class="<?php echo $active_section === $section_id ? 'active' : ''; ?>">
                                <a href="<?php echo esc_url(add_query_arg('section', $section_id)); ?>">
                                    <?php if (!empty($section['icon'])) : ?>
                                        <span class="dashicons <?php echo esc_attr($section['icon']); ?>"></span>
                                    <?php endif; ?>
                                    <?php echo esc_html($section['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <div class="wp-theme-settings-content">
                    <form method="post" action="options.php">
                        <?php settings_fields('wp_theme_settings_group'); ?>

                        <?php foreach ($sections as $section_id => $section) : ?>
                            <div class="wp-theme-section <?php echo $active_section === $section_id ? 'active' : ''; ?>" id="section-<?php echo esc_attr($section_id); ?>">
                                <h2><?php echo esc_html($section['title']); ?></h2>

                                <table class="form-table">
                                    <?php foreach ($section['fields'] as $field) : ?>
                                        <tr>
                                            <th scope="row">
                                                <label for="<?php echo esc_attr($field['id']); ?>">
                                                    <?php echo esc_html($field['label']); ?>
                                                </label>
                                            </th>
                                            <td>
                                                <?php $this->render_field($field, $settings); ?>
                                                <?php if (!empty($field['desc'])) : ?>
                                                    <p class="description"><?php echo esc_html($field['desc']); ?></p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php endforeach; ?>

                        <?php submit_button(); ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render a single field
     */
    private function render_field(array $field, array $settings): void
    {
        $value = $settings[$field['id']] ?? ($this->get_defaults()[$field['id']] ?? '');
        $name = self::OPTION_NAME . '[' . $field['id'] . ']';

        switch ($field['type']) {
            case 'color':
                printf(
                    '<input type="text" class="wp-color-picker" id="%s" name="%s" value="%s">',
                    esc_attr($field['id']),
                    esc_attr($name),
                    esc_attr($value)
                );
                break;

            case 'select':
                printf('<select id="%s" name="%s">', esc_attr($field['id']), esc_attr($name));
                foreach ($field['options'] as $opt_value => $opt_label) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($opt_value),
                        selected($value, $opt_value, false),
                        esc_html($opt_label)
                    );
                }
                echo '</select>';
                break;

            case 'textarea':
                printf(
                    '<textarea class="large-text" rows="3" id="%s" name="%s">%s</textarea>',
                    esc_attr($field['id']),
                    esc_attr($name),
                    esc_textarea($value)
                );
                break;

            case 'text':
            default:
                printf(
                    '<input type="text" class="regular-text" id="%s" name="%s" value="%s">',
                    esc_attr($field['id']),
                    esc_attr($name),
                    esc_attr($value)
                );
                break;
        }
    }
}

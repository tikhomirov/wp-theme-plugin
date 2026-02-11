<?php
/**
 * Assets management - Bootstrap 5 and theme styles/scripts
 *
 * @package theme_plugin
 */

namespace theme_plugin\src;

defined('ABSPATH') || exit;

/**
 * Assets class
 *
 * Handles all CSS/JS enqueuing for the theme.
 */
class Assets
{
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
     * Initialize assets hooks
     */
    public function add_actions(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles'], 5);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 5);
        add_action('wp_head', [$this, 'output_css_variables'], 5);
    }

    /**
     * Enqueue styles
     */
    public function enqueue_styles(): void
    {
        // Google Fonts
        $this->enqueue_google_fonts();

        // Bootstrap 5 CSS (from CDN or local)
        wp_enqueue_style(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
            [],
            '5.3.2'
        );

        // WooCommerce Bootstrap 5 overrides
        if (class_exists('WooCommerce')) {
            $woo_css = $this->url . 'assets/css/woocommerce.css';
            $woo_css_path = $this->path . 'assets/css/woocommerce.css';
            
            if (file_exists($woo_css_path)) {
                wp_enqueue_style(
                    'wp-theme-woocommerce',
                    $woo_css,
                    ['bootstrap'],
                    $this->get_file_version($woo_css_path)
                );
            }
        }

        // Main theme styles from plugin
        $theme_css = $this->url . 'assets/css/theme.css';
        $theme_css_path = $this->path . 'assets/css/theme.css';
        
        if (file_exists($theme_css_path)) {
            wp_enqueue_style(
                'wp-theme-main',
                $theme_css,
                ['bootstrap'],
                $this->get_file_version($theme_css_path)
            );
        }
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts(): void
    {
        // jQuery (WordPress built-in)
        wp_enqueue_script('jquery');

        // Bootstrap 5 JS bundle (includes Popper)
        wp_enqueue_script(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
            ['jquery'],
            '5.3.2',
            true
        );

        // Main theme JS
        $theme_js = $this->url . 'assets/js/theme.js';
        $theme_js_path = $this->path . 'assets/js/theme.js';
        
        if (file_exists($theme_js_path)) {
            wp_enqueue_script(
                'wp-theme-main',
                $theme_js,
                ['jquery', 'bootstrap'],
                $this->get_file_version($theme_js_path),
                true
            );

            // Localize script
            wp_localize_script('wp-theme-main', 'wpThemeVars', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('wp_theme_nonce'),
            ]);
        }
    }

    /**
     * Output CSS variables from theme settings
     */
    public function output_css_variables(): void
    {
        $settings = get_option('wp_theme_settings', []);

        // Default values
        $primary_color = $settings['primary_color'] ?? '#0d6efd';
        $secondary_color = $settings['secondary_color'] ?? '#6c757d';
        $success_color = $settings['success_color'] ?? '#198754';
        $danger_color = $settings['danger_color'] ?? '#dc3545';
        $warning_color = $settings['warning_color'] ?? '#ffc107';
        $info_color = $settings['info_color'] ?? '#0dcaf0';
        $light_color = $settings['light_color'] ?? '#f8f9fa';
        $dark_color = $settings['dark_color'] ?? '#212529';
        
        $body_font = $settings['body_font'] ?? 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
        $heading_font = $settings['heading_font'] ?? $body_font;
        $base_font_size = $settings['base_font_size'] ?? '16px';
        $border_radius = $settings['border_radius'] ?? '0.375rem';

        ?>
        <style id="wp-theme-css-variables">
        :root {
            --bs-primary: <?php echo esc_attr($primary_color); ?>;
            --bs-secondary: <?php echo esc_attr($secondary_color); ?>;
            --bs-success: <?php echo esc_attr($success_color); ?>;
            --bs-danger: <?php echo esc_attr($danger_color); ?>;
            --bs-warning: <?php echo esc_attr($warning_color); ?>;
            --bs-info: <?php echo esc_attr($info_color); ?>;
            --bs-light: <?php echo esc_attr($light_color); ?>;
            --bs-dark: <?php echo esc_attr($dark_color); ?>;
            
            --bs-body-font-family: <?php echo esc_attr($body_font); ?>;
            --bs-heading-font-family: <?php echo esc_attr($heading_font); ?>;
            --bs-body-font-size: <?php echo esc_attr($base_font_size); ?>;
            --bs-border-radius: <?php echo esc_attr($border_radius); ?>;
        }
        
        .btn-primary {
            --bs-btn-bg: <?php echo esc_attr($primary_color); ?>;
            --bs-btn-border-color: <?php echo esc_attr($primary_color); ?>;
        }
        
        a {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        a:hover {
            color: <?php echo esc_attr($this->darken_color($primary_color, 20)); ?>;
        }
        </style>
        <?php
    }

    /**
     * Get file version based on modification time
     */
    private function get_file_version(string $file_path): string
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            return (string) filemtime($file_path);
        }
        return '1.0.0';
    }

    /**
     * Darken a hex color
     */
    private function darken_color(string $hex, int $percent): string
    {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r = max(0, $r - ($r * $percent / 100));
        $g = max(0, $g - ($g * $percent / 100));
        $b = max(0, $b - ($b * $percent / 100));
        
        return sprintf('#%02x%02x%02x', (int) $r, (int) $g, (int) $b);
    }

    /**
     * Enqueue Google Fonts based on settings
     */
    private function enqueue_google_fonts(): void
    {
        $settings = get_option('wp_theme_settings', []);
        $body_font = $settings['body_font'] ?? '';
        $heading_font = $settings['heading_font'] ?? '';

        $fonts = [];

        // Map font family to Google Fonts name
        $font_map = [
            '"Open Sans", sans-serif' => 'Open+Sans:wght@400;500;600;700',
            '"Roboto", sans-serif' => 'Roboto:wght@400;500;700',
            '"Lato", sans-serif' => 'Lato:wght@400;700',
            '"Montserrat", sans-serif' => 'Montserrat:wght@400;500;600;700',
            '"Nunito", sans-serif' => 'Nunito:wght@400;600;700',
            '"Playfair Display", serif' => 'Playfair+Display:wght@400;500;600;700',
            '"Merriweather", serif' => 'Merriweather:wght@400;700',
            '"Oswald", sans-serif' => 'Oswald:wght@400;500;600;700',
            '"Raleway", sans-serif' => 'Raleway:wght@400;500;600;700',
        ];

        // Add body font
        if (!empty($body_font) && isset($font_map[$body_font])) {
            $fonts[] = $font_map[$body_font];
        }

        // Add heading font (if different from body)
        if (!empty($heading_font) && isset($font_map[$heading_font]) && $heading_font !== $body_font) {
            $fonts[] = $font_map[$heading_font];
        }

        // Enqueue Google Fonts if any selected
        if (!empty($fonts)) {
            $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
            wp_enqueue_style('wp-theme-google-fonts', $fonts_url, [], null);
        }
    }
}

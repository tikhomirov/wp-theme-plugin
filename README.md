# WP Theme Plugin

WordPress plugin providing Bootstrap 5 integration and WooCommerce support for the Bagel theme.

## Version

2.0.0

## Requirements

- WordPress 5.6+
- PHP 8.0+
- WooCommerce 8.0+ (for shop features)

## Features

### Core Features
- **Bootstrap 5 Integration** - CSS/JS enqueuing from CDN
- **WooCommerce Support** - Full shop styling and hooks
- **Theme Settings Page** - Admin panel for customization
- **Google Fonts** - Automatic font loading based on settings
- **CSS Variables** - Dynamic color and typography output

### Components
- **Menu Cart** - WooCommerce mini-cart in navbar
- **Page Loader** - Loading animation
- **To Top Button** - Scroll to top functionality
- **Progress Bar** - Page load progress indicator
- **Bootstrap Mega Menu** - Enhanced dropdown menus
- **Menu Cache** - Performance optimization

## Installation

1. Upload the `wp-theme-plugin` folder to `/wp-content/plugins/`
2. Activate the plugin in WordPress admin
3. Configure settings in **Theme Settings** menu

## Structure

```
wp-theme-plugin/
├── src/                        # Main source classes
│   ├── class-assets.php       # Bootstrap 5 & Google Fonts enqueue
│   ├── Admin/
│   │   └── class-admin-page.php  # Settings page
│   └── Woo/
│       └── class-woocommerce-setup.php  # WooCommerce hooks
├── assets/
│   ├── css/
│   │   ├── theme.css          # Main theme styles
│   │   ├── woocommerce.css    # WooCommerce BS5 styles
│   │   ├── admin.css          # Admin page styles
│   │   └── style.css          # Component styles
│   └── js/
│       ├── theme.js           # Frontend JavaScript
│       └── admin.js           # Admin JavaScript
├── classes/                    # Legacy classes
├── components/                 # Feature components
├── lib/
│   └── wp-field/              # Form field library
├── templates/                  # HTML templates
├── functions.php              # Helper functions
└── wp-theme.php               # Main plugin file
```

## Settings

### Colors
- Primary, Secondary, Success, Danger, Warning, Info colors
- Header/Footer background and text colors

### Typography
- Body font family (with Google Fonts support)
- Heading font family
- Base font size

### Header
- Header style (Default, Centered, Minimal)
- Sticky header toggle
- Search icon toggle
- Cart icon toggle

### Footer
- Number of widget columns (1-4)
- Custom copyright text
- Social links toggle

### WooCommerce
- Products per row (2-6)
- Products per page (8-24)
- Sale badge toggle
- Rating display toggle
- Cart icon style

### Layout
- Border radius presets

## Usage

### CSS Variables

The plugin outputs CSS variables that can be used in your theme:

```css
:root {
    --bs-primary: #0d6efd;
    --bs-secondary: #6c757d;
    --bs-body-font-family: "Open Sans", sans-serif;
    --bs-body-font-size: 16px;
    --bs-border-radius: 0.375rem;
}
```

### Getting Settings

```php
$settings = get_option('wp_theme_settings', []);
$primary_color = $settings['primary_color'] ?? '#0d6efd';
```

### WooCommerce Hooks

The plugin automatically applies Bootstrap 5 classes to:
- Product grid (responsive columns)
- Breadcrumbs (Bootstrap breadcrumb component)
- Pagination (Bootstrap pagination)
- Notices (Bootstrap alerts)
- Forms (form-control, form-select classes)
- Buttons (btn classes)

## Development

### Adding New Settings

1. Add default value in `Admin_Page::get_defaults()`
2. Add sanitization in `Admin_Page::sanitize_settings()`
3. Add field definition in appropriate `get_*_fields()` method
4. Use setting in Assets or WooCommerce_Setup classes

### Extending WooCommerce

Add hooks in `WooCommerce_Setup::add_actions()`:

```php
add_filter('woocommerce_*', [$this, 'your_method']);
```

## Changelog

### 2.0.0
- Complete rewrite with new architecture
- Added Admin settings page with tabs
- Added WooCommerce Bootstrap 5 integration
- Added Google Fonts support
- Added CSS variables output
- Added header/footer customization
- Improved code organization (PSR-4 style)

### 1.x
- Original component-based plugin

## License

GPL v2 or later
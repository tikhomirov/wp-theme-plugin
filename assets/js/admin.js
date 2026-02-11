/**
 * Admin JavaScript for Theme Settings page
 *
 * @package theme_plugin
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize color pickers
        $('.wp-color-picker').wpColorPicker();

        // Tab navigation (if using JS tabs instead of page reload)
        $('.wp-theme-settings-nav a').on('click', function(e) {
            var href = $(this).attr('href');
            
            // If it's a hash link, handle with JS
            if (href.indexOf('#') === 0) {
                e.preventDefault();
                
                var targetSection = href.replace('#', '');
                
                // Update nav
                $('.wp-theme-settings-nav li').removeClass('active');
                $(this).parent().addClass('active');
                
                // Update sections
                $('.wp-theme-section').removeClass('active');
                $('#section-' + targetSection).addClass('active');
            }
        });

        // Show unsaved changes warning
        var formChanged = false;
        
        $('.wp-theme-settings-content form').on('change', 'input, select, textarea', function() {
            formChanged = true;
        });

        $(window).on('beforeunload', function() {
            if (formChanged) {
                return 'You have unsaved changes. Are you sure you want to leave?';
            }
        });

        $('.wp-theme-settings-content form').on('submit', function() {
            formChanged = false;
        });
    });

})(jQuery);

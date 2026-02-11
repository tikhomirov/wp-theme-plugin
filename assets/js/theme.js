/**
 * Theme main JavaScript
 *
 * Bootstrap 5 + jQuery behaviors
 *
 * @package theme_plugin
 */

(function($) {
    'use strict';

    /**
     * Initialize all theme components
     */
    function init() {
        initOffcanvas();
        initScrollToTop();
        initSmoothScroll();
        initDropdowns();
        initWooCommerce();
    }

    /**
     * Initialize Bootstrap offcanvas for mobile menu
     */
    function initOffcanvas() {
        // Close offcanvas when clicking on a link
        $(document).on('click', '.offcanvas-body a', function() {
            var offcanvasEl = $(this).closest('.offcanvas');
            if (offcanvasEl.length) {
                var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl[0]);
                if (offcanvas) {
                    offcanvas.hide();
                }
            }
        });
    }

    /**
     * Scroll to top button
     */
    function initScrollToTop() {
        var $btn = $('.scroll-to-top');
        
        if (!$btn.length) {
            return;
        }

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $btn.fadeIn();
            } else {
                $btn.fadeOut();
            }
        });

        $btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 400);
        });
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            if (
                location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname
            ) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 500);
                }
            }
        });
    }

    /**
     * Bootstrap dropdown enhancements
     */
    function initDropdowns() {
        // Keep dropdown open on hover for desktop
        if (window.innerWidth >= 992) {
            $('.navbar .dropdown').on('mouseenter', function() {
                var $dropdown = $(this).find('.dropdown-menu');
                $dropdown.addClass('show');
                $(this).find('.dropdown-toggle').attr('aria-expanded', 'true');
            }).on('mouseleave', function() {
                var $dropdown = $(this).find('.dropdown-menu');
                $dropdown.removeClass('show');
                $(this).find('.dropdown-toggle').attr('aria-expanded', 'false');
            });
        }
    }

    /**
     * WooCommerce specific behaviors
     */
    function initWooCommerce() {
        if (typeof wc_add_to_cart_params === 'undefined') {
            return;
        }

        // Update mini cart on add to cart
        $(document.body).on('added_to_cart', function(e, fragments, cart_hash, $button) {
            // Show success feedback
            $button.addClass('added');
            setTimeout(function() {
                $button.removeClass('added');
            }, 2000);
        });

        // Scroll to notices
        $(document.body).on('checkout_error', function() {
            var $notice = $('.woocommerce-error, .woocommerce-message').first();
            if ($notice.length) {
                $('html, body').animate({
                    scrollTop: $notice.offset().top - 100
                }, 500);
            }
        });

        // Product gallery lightbox trigger
        $('.woocommerce-product-gallery__image a').on('click', function(e) {
            // Let WooCommerce handle this if photoswipe is loaded
            if (typeof PhotoSwipe !== 'undefined') {
                return;
            }
            e.preventDefault();
            // Fallback: open image in new tab
            window.open($(this).attr('href'), '_blank');
        });

        // Variation form handling
        $('.variations_form').on('found_variation', function(e, variation) {
            // Update price display
            if (variation.price_html) {
                $(this).closest('.product').find('.price').first().html(variation.price_html);
            }
        });

        // Reset variation
        $('.variations_form').on('reset_data', function() {
            var $product = $(this).closest('.product');
            var originalPrice = $product.find('.price').data('original-price');
            if (originalPrice) {
                $product.find('.price').first().html(originalPrice);
            }
        });

        // Store original price
        $('.variations_form').each(function() {
            var $product = $(this).closest('.product');
            var $price = $product.find('.price').first();
            $price.data('original-price', $price.html());
        });
    }

    /**
     * Document ready
     */
    $(document).ready(function() {
        init();
    });

    /**
     * Window load (after all resources loaded)
     */
    $(window).on('load', function() {
        // Remove page loader if exists
        $('.page-loader').fadeOut(300);
    });

})(jQuery);

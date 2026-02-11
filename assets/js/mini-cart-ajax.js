jQuery(function($) {
    function positionMiniCartDropdown($toggle) {
        var $miniCart = $toggle.closest('.mini-cart');
        var $menu = $miniCart.find('.dropdown-menu-mini-cart');

        if (!$menu.length) {
            return;
        }

        var rect = $toggle[0].getBoundingClientRect();
        var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
        var viewportHeight = window.innerHeight || document.documentElement.clientHeight;

        var horizontalPadding = 10;
        var verticalPadding = 20;
        var gap = 8;
        var desiredWidth = Math.min(360, Math.max(240, viewportWidth - (horizontalPadding * 2)));
        var left = rect.right - desiredWidth;

        if (left < horizontalPadding) {
            left = horizontalPadding;
        }

        if (left + desiredWidth > viewportWidth - horizontalPadding) {
            left = viewportWidth - horizontalPadding - desiredWidth;
        }

        var top = rect.bottom + gap;
        var availableHeight = viewportHeight - top - verticalPadding;
        var maxHeight = Math.min(520, Math.max(180, availableHeight));

        $menu.css({
            position: 'fixed',
            top: top + 'px',
            left: left + 'px',
            right: 'auto',
            bottom: 'auto',
            width: desiredWidth + 'px',
            maxHeight: maxHeight + 'px',
            overflowY: 'auto',
            overflowX: 'hidden',
            zIndex: 2000,
            transform: 'none'
        });
    }

    var repositionTimer = null;
    function requestReposition() {
        if (repositionTimer) {
            clearTimeout(repositionTimer);
        }

        repositionTimer = setTimeout(function() {
            var $toggle = $('#dropdown-cart');
            if ($toggle.length && $toggle.attr('aria-expanded') === 'true') {
                positionMiniCartDropdown($toggle);
            }
        }, 30);
    }

    $(document).on('shown.bs.dropdown', '#dropdown-cart', function() {
        positionMiniCartDropdown($(this));
    });

    $(document).on('click', '#dropdown-cart', function() {
        var $toggle = $(this);

        setTimeout(function() {
            if ($toggle.length && $toggle.attr('aria-expanded') === 'true') {
                positionMiniCartDropdown($toggle);
            }
        }, 0);
    });

    $(document).on('hide.bs.dropdown', '#dropdown-cart', function() {
        var $miniCart = $(this).closest('.mini-cart');
        $miniCart.find('.dropdown-menu-mini-cart').attr('style', '');
    });

    $(window).on('resize scroll', requestReposition);

    // Обработка AJAX добавления в корзину
    $('body').on('added_to_cart', function(event, fragments, cart_hash, $button) {
        // Обновляем мини-корзину
        if (fragments && fragments['.mini-cart']) {
            $('.mini-cart').replaceWith(fragments['.mini-cart']);
        }
        
        // Обновляем счетчик товаров
        if (fragments && fragments['.cart-count']) {
            $('.cart-count').replaceWith(fragments['.cart-count']);
        }
        
        // Показываем уведомление
        if ($('.woocommerce-message').length === 0) {
            // Если нет сообщения об успешном добавлении, покажем свое
            var message = '<div class="woocommerce-message" role="alert">Товар добавлен в корзину</div>';
            $('form.cart').before(message);
            
            // Автоматически скроем сообщение через 3 секунды
            setTimeout(function() {
                $('.woocommerce-message').fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }
    });

    // Обработка удаления из корзины
    $(document).on('click', '.remove_from_cart_button', function(e) {
        e.preventDefault();
        
        var $this = $(this);
        var cart_item_key = $this.data('cart_item_key');
        
        // Показываем индикатор загрузки
        $this.html('<i class="fas fa-spinner fa-spin"></i>');

        var removeUrl = (typeof wc_cart_fragments_params !== 'undefined' && wc_cart_fragments_params.wc_ajax_url)
            ? wc_cart_fragments_params.wc_ajax_url.toString().replace('%%endpoint%%', 'remove_from_cart')
            : '/?wc-ajax=remove_from_cart';
        
        $.ajax({
            type: 'POST',
            url: removeUrl,
            data: {
                cart_item_key: cart_item_key
            },
            success: function(response) {
                if (response && response.fragments) {
                    // Обновляем мини-корзину
                    if (response.fragments['.mini-cart']) {
                        $('.mini-cart').replaceWith(response.fragments['.mini-cart']);
                    }
                    
                    // Обновляем счетчик товаров
                    if (response.fragments['.cart-count']) {
                        $('.cart-count').replaceWith(response.fragments['.cart-count']);
                    }
                    
                    // Обновляем другие фрагменты
                    $.each(response.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });

                    requestReposition();
                }
            },
            error: function() {
                // Восстанавливаем кнопку в случае ошибки
                $this.html('<button type="button" class="btn-close" disabled aria-label="Close"></button>');
            }
        });
    });
});

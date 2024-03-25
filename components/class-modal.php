<?php
/**
 * Modal window
 */

namespace theme_plugin\components;

use Exception;
use WC_Order;
use WC_Order_Refund;

class Modal {

	public function __construct() {

	}

	public function add_actions() {

		add_action( 'wp_footer', [ $this, 'wp_modal_thx' ], 9, 1 );
		add_action( 'wp_footer', [ $this, 'wp_modal_auth' ], 9, 1 );
		add_action( 'wp_footer', [ $this, 'wp_modal_checkout' ], 8, 1 );
		add_action( 'wp_footer', [ $this, 'wp_modal_empty' ], 9, 1 );
		add_action( 'wp_footer', [ $this, 'js' ], 99 );

		add_action( 'wp_ajax_nopriv_wc_lessons', [ $this, 'ajax_wc_lessons' ] );
		add_action( 'wp_ajax_wc_lessons', [ $this, 'ajax_wc_lessons' ] );

		add_action( 'wp_ajax_nopriv_wc_render_html', [ $this, 'render_modal_content' ] );
		add_action( 'wp_ajax_wc_render_html', [ $this, 'render_modal_content' ] );
	}

	/**
	 * Render modal thx
	 * @return void
	 */
	public function wp_modal_thx() {

        global $order;
		$order = $this->mb_get_order();

		if ( empty( $order ) ) {
			return;
		}

		?>
        <!-- Modal -->
        <div class="modal" id="modal_thx" tabindex="-1" aria-labelledby="thx_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="thx_label">Спасибо за заказ!</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="las la-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">

						<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

						<?php
						if ( $order->has_status( 'failed' ) ) : ?>

                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php
								esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.',
									'woocommerce' ); ?></p>
                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                                <a href="<?php
								echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php
									esc_html_e( 'Pay', 'woocommerce' ); ?></a>
								<?php
								if ( is_user_logged_in() ) : ?>
                                    <a href="<?php
									echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php
										esc_html_e( 'My account', 'woocommerce' ); ?></a>
								<?php
								endif; ?>
                            </p>

						<?php
						else : ?>

                            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php
								echo apply_filters( 'woocommerce_thankyou_order_received_text',
									esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ),
									$order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                                <li class="woocommerce-order-overview__order order">
									<?php
									esc_html_e( 'Order number:', 'woocommerce' ); ?>
                                    <strong><?php
										echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                                </li>

                                <li class="woocommerce-order-overview__date date">
									<?php
									esc_html_e( 'Date:', 'woocommerce' ); ?>
                                    <strong><?php
										echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                                </li>

								<?php
								if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                                    <li class="woocommerce-order-overview__email email">
										<?php
										esc_html_e( 'Email:', 'woocommerce' ); ?>
                                        <strong><?php
											echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                                    </li>
								<?php
								endif; ?>

                                <li class="woocommerce-order-overview__total total">
									<?php
									esc_html_e( 'Total:', 'woocommerce' ); ?>
                                    <strong><?php
										echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                                </li>
								<?php
								if ( $order->get_payment_method_title() ) : ?>
                                    <li class="woocommerce-order-overview__payment-method method">
										<?php
										esc_html_e( 'Payment method:', 'woocommerce' ); ?>
                                        <strong><?php
											echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                                    </li>
								<?php
								endif; ?>
                            </ul>
						<?php
						endif; ?>

	                    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
	                    <?php // do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

						<?php

                        if( in_array( $order->get_status(), [ 'on-hold', 'processing' ] )){
	                        WC()->payment_gateways();
	                        // The "Payment instructions" will be displayed with that:
	                        do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
                        }

						do_action( 'woocommerce_order_details_before_order_table', $order, false );
						?>

                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Helper
	 * @return bool|WC_Order|WC_Order_Refund|null
	 */
	public function mb_get_order() {
		return isset( $_GET['order_id'] ) ? wc_get_order( $_GET['order_id'] ) : null;
	}

	public function wp_modal_empty($title ='', $content = '') {
		?>
        <!-- Modal -->
        <div class="modal" id="modal" tabindex="-1" aria-labelledby="modal_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="modal_label"><?= $title ?></h4>
                        <button type="button" class="back">
                            <i class="las la-angle-left"></i>
                        </button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="las la-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
						<?= do_shortcode( $content ); ?>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Render modal Auth
	 * @return void
	 */
	public function wp_modal_auth() {
		?>
        <!-- Modal -->
        <div class="modal" id="modal_auth" tabindex="-1" aria-labelledby="auth_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="auth_label">Авторизация</h4>
                        <button type="button" class="back">
                            <i class="las la-angle-left"></i>
                        </button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="las la-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
						<?= do_shortcode( '[woocommerce_my_account]' ); ?>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Render modal checkout
	 * @return void
	 */
	public function wp_modal_checkout() { // modal_checkout
		?>
        <!-- Modal Checkout -->
        <div class="modal fade" id="modal_checkout" tabindex="-1" aria-labelledby="checkout_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fs-5" id="checkout_label">Оформление заказа</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="las la-times-circle"></i>
                            <!--<span aria-hidden="true">&times;</span>-->
                        </button>
                    </div>
                    <div class="modal-body">
						<?= do_shortcode( '[woocommerce_checkout]' ); ?>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	/**
	 * @return void
	 */
	public function js() {
		?>
        <script>
            jQuery(document).ready(function ($) {

                let preloader = $('.page-loading');

				<?php if(! empty( $this->mb_get_order() )): ?>
                    $('#modal_thx').modal('show');
				<?php endif;?>

                $('theme-data-product]').each(function(){
                    $(this).click(function (e) {
                        //console.log('lesson-checkout clocked')
                        e.preventDefault();
                        let product_id = $(this).data('product');

                        preloader.addClass('active').show();
                        // AJAX request
                        $.ajax({
                            url: '<?= admin_url( 'admin-ajax.php', 'relative' ); ?>',
                            data: {
                                action: 'wc_lessons',
                                'product_id': product_id,
                                _nonce: '<?= wp_create_nonce( 'wc_lesson' ); ?>'
                            },
                            type: 'POST',
                            success: function (response) {
                                //console.log(response);
                                preloader.removeClass('active').hide();
                                if (false === response.success) {
                                    $('#modal_checkout .modal-body').html(response.data);
                                } else {
                                    // Add response in Modal body
                                    $('#modal_checkout .modal-body').html(response);
                                    // Display Modal
                                    $('#modal_checkout').modal('show');
                                }
                                show_login();
                            }
                        });
                    });
                });

                function show_login() {
                    $('.showlogin').on('click', function (e) {
                        e.preventDefault();
                        $('#modal_checkout').modal('hide');
                        $('#modal_auth').modal('show')
                    });

                    $('.showcoupon').on('click', function (e){
                        e.preventDefault();
                        $('#modal_checkout').modal('hide');
                        preloader.addClass('active').show();
                        $.ajax({
                            url: '<?= admin_url( 'admin-ajax.php', 'relative' ); ?>',
                            data: {
                                action: 'wc_render_html',
                                shortcode: 'wc_coupon',
                                _nonce: '<?= wp_create_nonce( 'wc_lesson' ); ?>'
                            },
                            type: 'POST',
                            success: function (response) {
                                console.log(response);
                                preloader.removeClass('active').hide();
                                $('#modal .modal-title').html("Промокод");
                                if (false === response.success) {
                                    $('#modal .modal-body').html(response.data);
                                } else {
                                    // Add response in Modal body
                                    $('#modal .modal-body').html(response);
                                }
                                // Display Modal
                                $('#modal').modal('show');
                            }
                        });
                    });

                    back_btn();
                }

                function back_btn(){
                    $('button.back').on('click', function (){
                        $('#modal').modal('hide');
                        $('#modal_auth').modal('hide');
                        $('#modal_checkout').modal('show');
                    });
                }

            });
        </script>
		<?php
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function ajax_wc_lessons() {

		$nonce      = $_POST['_nonce'];
		$product_id = is_array( $_POST['product_id'] ) ? $_POST['product_id'] : absint( $_POST['product_id'] );

		if ( ! wp_verify_nonce( $nonce, 'wc_lesson' ) ) {
			wp_send_json_error( 'error!' );
		}

		$settings = [ 'cta' => [ '2_coupon' => null ] ];
		WC()->cart->empty_cart();
		if ( is_array( $product_id ) ) {
			foreach ( $product_id as $id ) {
				WC()->cart->add_to_cart( $id );
			}
			if ( ! empty( $settings['cta']['2_coupon'] ) ) {
				$coupon = wc_get_coupon_code_by_id( (int) $settings['cta']['2_coupon'] );
				WC()->cart->apply_coupon( $coupon );
			}
		} else {
			WC()->cart->add_to_cart( $product_id );
		}

		echo do_shortcode( '[woocommerce_checkout]' );
		wp_die();
	}

	/**
     * wc_render_html
	 * @return void
	 */
    public function render_modal_content(){
	    $nonce     = $_POST['_nonce'];
	    $shortcode = $_POST['shortcode'] ?? null;
	    if ( ! wp_verify_nonce( $nonce, 'wc_lesson' ) || empty($shortcode)) {
		    wp_send_json_error( 'error!' );
	    }

	    if('wc_coupon' === $shortcode) {
		    //$this->coupon_form();
	    }

        if('wp_modal_auth' === $shortcode) {
	        $this->wp_modal_auth();
        }

        wp_die();
    }

    private function coupon_form(){
        ?>
        <form class="checkout_coupon woocommerce-form-coupon" method="post">

            <p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'understrap' ); ?></p>

            <p class="form-row form-row-first">
                <input type="text" name="coupon_code" class="form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'understrap' ); ?>" id="coupon_code" value="" />
            </p>

            <p class="form-row form-row-last">
                <button type="submit" class="btn btn-outline-primary" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'understrap' ); ?>"><?php esc_html_e( 'Apply coupon', 'understrap' ); ?></button>
            </p>

            <div class="clear"></div>
        </form>
        <script>
            jQuery(document).ready(function ($) {
                $('[name="apply_coupon"]').on('click', function (e){
                    e.preventDefault();
                    $.ajax({
                        url: '<?= admin_url( 'admin-ajax.php', 'relative' ); ?>',
                        data: {
                            action: 'wc_lessons',
                            'product_id': product_id,
                            _nonce: '<?= wp_create_nonce( 'wc_lesson' ); ?>'
                        },
                        type: 'POST',
                        success: function (response) {
                            //console.log(response);
                            preloader.removeClass('active').hide();
                            if (false === response.success) {
                                $('#modal_checkout .modal-body').html(response.data);
                            } else {
                                // Add response in Modal body
                                $('#modal_checkout .modal-body').html(response);
                                // Display Modal
                                $('#modal_checkout').modal('show');
                            }
                            show_login();
                        }
                    });
                });
            });
        </script>
        <?php
    }
}
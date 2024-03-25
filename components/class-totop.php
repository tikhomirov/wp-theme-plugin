<?php

namespace theme_plugin\components;

class ToTop {
	public function add_actions() {
		add_action('wp_enqueue_scripts', [$this, 'scripts'], 9);
		add_action('wp_footer', [$this, 'render_html']);
	}

	public function scripts() {
		wp_add_inline_style('wp-theme', $this->css());
		wp_add_inline_script('jquery', $this->js());
	}

	public function render_html() {
		?>
		<div class="back-to-top">
			<i class="icon-arrow-up"></i>
		</div>
		<?php
	}

	public function css() {
			ob_start()
			?>
			<style>
                .back-to-top {
                    position: fixed;
                    bottom: 30px;
                    right: 15px;
                    opacity: 0;
                    transition: .3s all ease;
                    cursor: pointer;
                    width: 50px;
                    height: 50px;
                    text-align: center;
                    overflow: hidden;
                    z-index: 5000;
                    color: #cecece;
                    border: 2px solid #cecece;
                    border-radius: 100px;
                }
                .back-to-top {
                    box-shadow: 0 3px 13px 1px rgba(0,0,0,.12);
                    background-color: #fff;
                    border-width: 0!important;
                    font-size: 20px;
                }
                .back-to-top:hover {
                    background: #32323f;
                    color: #cecece;
                }
                .back-to-top.active {
                    opacity: 1;
                }
                .back-to-top i {
                    display: block;
                    line-height: 46px;
                    font-size: 20px;
                }
			</style>
			<?php
			return str_replace(['<style>','</style>'], [''], ob_get_clean());
	}

	public function js() {
		ob_start();
		?>
		<script>
            jQuery(function ($) {
                $('.back-to-top').click(function () {
                    $('body,html').animate({scrollTop: 0}, 150); // 800 - Скорость анимации
                });

                $(window).scroll(function () {
                    let scrolled = $(window).scrollTop();

                    if (scrolled > 350) {
                        $('.back-to-top').addClass('active');
                    } else {
                        $('.back-to-top').removeClass('active');
                    }
                });
            });
		</script>
		<?php
		return str_replace(['<script>','</script>'], [''], ob_get_clean());
	}
}
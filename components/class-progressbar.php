<?php

namespace theme_plugin\components;

class Progressbar {
	public function add_actions() {
		add_action('wp_enqueue_scripts', [$this, 'scripts'], 9);
		add_action('wp_body_open', [$this, 'render_html']);
	}

	public function scripts() {
		wp_add_inline_style('wp-theme', $this->css());
		wp_add_inline_script('jquery', $this->js());
	}

	public function render_html() {
		if(is_singular('post')){
		?>
		<div class="public-progress-bar" id="progressBar"></div>
		<?php
		}
	}

	public function css() {
		ob_start()
		?>
		<style>
            .public-progress-bar {
                position: fixed;
                bottom: 0;
                height: 2px;
                /*width: 12px;*/
                background: #FF5722;
                z-index: 99;
                border-radius: 5px;
                box-shadow: -10px 0 20px 2px rgba(0,0,0,.06);
            }
		</style>
		<?php
		return str_replace(['<style>','</style>'], [''], ob_get_clean());
	}

	public function js() {
		ob_start();
		?>
		<script>
            function progressBar() {
                let scroll = document.body.scrollTop || document.documentElement.scrollTop;
                let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                let scrolled = scroll / height * 100;
                let bar = document.getElementById('progressBar');
                if(null !== bar) {
                    bar.style.width = scrolled + '%';
                }
            }
            window.addEventListener('scroll', progressBar);
		</script>
		<?php
		return str_replace(['<script>','</script>'], [''], ob_get_clean());
	}
}
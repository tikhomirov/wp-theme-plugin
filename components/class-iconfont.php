<?php

namespace theme_plugin\components;

class IconFont
{
    public string $file;
    public string $url;
    public string $font;
    public string $assets;
    public string $ver;
    public string $iconfont; // 'simple-line-icons' or 'line-awesome'

    public function __construct(string $iconfont = 'simple-line-icons') {
        $this->file   = WP_THEME_PLUGIN;
        $this->url    = plugin_dir_url($this->file);
        $this->assets = $this->url . 'assets';
        $this->ver    = defined('WP_DEBUG') && WP_DEBUG ? time() : '1.0';
        $this->iconfont = $iconfont;
    }

    public function add_actions() {
        add_action('wp_enqueue_scripts', [$this, 'add_font'], 9);
    }

    public function add_font()
    {
        wp_enqueue_style( $this->iconfont, $this->assets . '/css/' . $this->iconfont . '.css', false, $this->ver );
    }

}
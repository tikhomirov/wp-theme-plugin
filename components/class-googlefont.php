<?php

namespace theme_plugin\components;

class GoogleFont
{
    public $file;
    public $url;
    public $font;
    public $assets;
    public $ver;

    public function __construct() {
        $this->file = WP_THEME_PLUGIN;
        $this->url = plugin_dir_url($this->file);
        $this->assets = $this->url . 'assets';
        $this->ver = defined('WP_DEBUG') && WP_DEBUG ? time() : '1.0';
    }

    public function add_actions() {
        add_action('wp_head',			   [$this, 'pre_connect'], 1 );
        add_action('wp_enqueue_scripts', [$this, 'add_font'], 9);
    }

    public function pre_connect()
    {
        echo ('<link rel="preconnect" href="https://fonts.gstatic.com">');
    }

    public function add_font()
    {
        wp_enqueue_style( 'open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,700&display=swap', false );
        wp_enqueue_style('wp-theme',$this->assets . '/css/style.css', false, $this->ver);

        $this->add_la_icons();
    }

    public function add_la_icons()
    {
        wp_enqueue_style( 'line-awesome', $this->assets . '/css/line-awesome.css', false, $this->ver );
    }

}
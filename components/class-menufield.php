<?php

namespace theme_plugin\components;

use ContentBlock;
use WP_Field;

class MenuField
{
    public static array $field_keys = [
        'use_mega_menu' => [
            'title' => 'Use Mega Menu. With 1/2 columns',
            'type'  => 'checkbox',
        ],
        'icon'          => [
            'title' => 'SVG Icon',
            'desc'  => 'Set svg icon class. Empty for not use it.',
        ],
        'content'       => [
            'title'   => 'Mega menu content',
            'desc'    => 'Mega menu content.',
            'type'    => 'select',
            'options' => []
        ],
    ];
    public array $fields;
    /** @var ContentBlock|null */
    public $plugin;

    public function __construct()
    {
        $this->fields = static::$field_keys;
        if (class_exists('ContentBlock')) {
            $this->plugin = ContentBlock::get_Instance();
            $this->fields['content'] = $this->plugin->content_block_list;
        }
    }

    public static function save_fields($menu_id, $item_id)
    {

        foreach (self::$field_keys as $meta_key => $data) {
            self::save_field($menu_id, $item_id, $meta_key);
        }
    }

    private static function save_field($menu_id, $item_id, $meta_key)
    {

        if (!isset($_POST[$meta_key][$item_id])) {
            return;
        }

        $val = $_POST[$meta_key][$item_id];

        if ($val) {
            update_post_meta($item_id, $meta_key, sanitize_text_field($val));
        } else {
            delete_post_meta($item_id, $meta_key);
        }

    }

    public static function nav_menu_start_el($item_output, $post)
    {

        $svg = $post->_menu_item_svg_icon ?: '';
        if ($svg) {
            //$svg = get_svg( $svg );
        }

        return str_replace('{SVG}', $svg, $item_output);
    }

    public static function nav_menu_args($args)
    {

        if (empty($args['link_before'])) {
            $args['link_before'] = '{SVG}';
        }

        return $args;
    }

    public function add_actions(): void
    {

        if (is_admin()) {
            add_action('wp_nav_menu_item_custom_fields', [$this, 'add_fileds'], 10, 2);
            add_action('wp_update_nav_menu_item', [__CLASS__, 'save_fields'], 10, 2);
        } // front
        else {
            add_filter('walker_nav_menu_start_el', [__CLASS__, 'nav_menu_start_el'], 10, 2);
            add_filter('wp_nav_menu_args', [__CLASS__, 'nav_menu_args']);
        }

    }

    public function add_fileds($item_id, $item)
    {

        foreach ($this->fields as $meta_key => $data) {

            $value = get_post_meta($item_id, $meta_key, true);
            $title = $data['title'];
            $type = $data['type'] ?? 'text';
            $size = $data['size'] ?? 'wide';

            if (class_exists('WP_Field')) {
                WP_Field::make([
                    [
                        'id'      => $item_id, // 'menu-item-'.
                        'type'    => $type ?? 'text',
                        'title'   => $data['desc'] ?? '',
                        'options' => $data['options'] ?? [],
                    ],
                    'post',
                    $item_id
                ]);
                return;
            }

            $desc = empty($data['desc']) ? '' : '<span class="description">'.$data['desc'].'</span>';
            ?>
            <p class="field-<?= $meta_key ?> description description-<?= $size ?>">
                <?= $title ?>
                <br/>
                <input class="widefat edit-menu-item-<?= $meta_key ?>"
                       type="<?= $type ?>"
                       name="<?= sprintf('%s[%s]', $meta_key, $item_id) ?>"
                       id="menu-item-<?= $item_id ?>"
                       value="<?= esc_attr($value) ?>"
                />
                <?= $desc ?>
            </p>
            <?php
        }
    }
}
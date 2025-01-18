<?php
/**
 * BS 5 multilevel menu
 * https://github.com/kmlpandey77/bootnavbar/tree/master?tab=readme-ov-file
 */

namespace theme_plugin\components;

use theme_plugin\classes\Navi;

class BootstrapMegaMenu extends Plugin
{
    public string $file;
    public string $url;
    public string $assets;
    public string $ver;
    public $navigation;
    public mixed $icons;

    public function __construct()
    {
        $this->file = WP_THEME_PLUGIN;
        $this->url = plugin_dir_url($this->file);
        $this->assets = $this->url . 'assets';
        $this->ver = defined('WP_DEBUG') && WP_DEBUG ? time() : '1.0';
    }

    public function add_actions():void
    {
        $this->navigation = Navi::make()->withDefaultClasses()->build('primary');
        $this->icons = require_once dirname(__DIR__) . '/data/icons.php';

        add_action('wp_footer', [$this, 'js'], 99);
        add_action('wp_enqueue_scripts', [$this, 'css'], 9);
        add_action('print_menu', [$this, 'wp_nav_menu']);

        if(!is_admin()){
            return;
        }

        add_action( 'wp_nav_menu_item_custom_fields', [$this, 'my_wp_nav_menu_item_custom_fields'], 10, 4 );
        add_action( 'wp_update_nav_menu_item', [$this, 'my_wp_update_nav_menu_item'], 10, 3 );
        add_filter( 'nav_menu_link_attributes', [$this, 'my_wp_nav_menu_link_attributes'], 10, 3 );

        // 2. Добавление пользовательского поля выбора сайдбара
        add_action('wp_nav_menu_item_custom_fields', [$this, 'choose_sidebar'], 10, 4);

        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_style( 'simple-line-icons', 'https://cdn.jsdelivr.net/npm/simple-line-icons@2.5.5/css/simple-line-icons.css' );
        });
    }

    public function css(){
        wp_enqueue_style('megamenu',$this->assets . '/css/megamenu.css', false, $this->ver);
        wp_enqueue_style('animate',$this->assets . '/css/animate.css', false, $this->ver);
    }

    public function js()
    {
        ?>
        <script>
            jQuery(document).ready(function () {

                // Select the <html> element
                let html = document.querySelectorAll('html')[0];

                // Select the first element with the attribute 'data-bs-toggle-theme'
                let themeToggle = document.querySelectorAll('*[data-bs-toggle-theme]')[0];

                // Set the default theme to 'dark' for the <html> element
                html.setAttribute('data-bs-theme', 'dark');

                // Check if a themeToggle element is found
                if (themeToggle) {
                    // Add a click event listener to the themeToggle element
                    themeToggle.addEventListener('click', function (event) {
                        // Prevent the default behavior of the click event
                        event.preventDefault();

                        // Check the current theme attribute value of the <html> element
                        if (html.getAttribute('data-bs-theme') === 'dark') {
                            // If the current theme is 'dark', change it to 'light'
                            html.setAttribute('data-bs-theme', 'light');
                        } else {
                            // If the current theme is not 'dark', change it back to 'dark'
                            html.setAttribute('data-bs-theme', 'dark');
                        }
                    });
                }

                function bootnavbar(options) {

                    const defaultOption = {
                        selector: "main-nav",
                        animation: true,
                        animateIn: "animate__fadeIn",
                    };

                    const bnOptions = {...defaultOption, ...options};

                    init = function () {
                        var dropdowns = document.getElementById(bnOptions.selector);

                        if (!dropdowns) {
                            console.error(`Element with ID ${bnOptions.selector} not found.`);
                            return; // Прекращаем выполнение, если элемент не найден
                        }

                        var items = dropdowns.getElementsByClassName("dropdown");

                        Array.prototype.forEach.call(items, (item) => {
                            // Добавление анимации
                            if (bnOptions.animation) {
                                const element = item.querySelector(".dropdown-menu");
                                if (element) { // Проверяем, существует ли элемент
                                    element.classList.add("animate__animated");
                                    element.classList.add(bnOptions.animateIn);
                                }
                            }

                            // Эффекты наведения
                            item.addEventListener("mouseover", function () {
                                this.classList.add("show");
                                const element = this.querySelector(".dropdown-menu");
                                if (element) {
                                    element.classList.add("show");
                                }
                            });

                            item.addEventListener("mouseout", function () {
                                this.classList.remove("show");
                                const element = this.querySelector(".dropdown-menu");
                                if (element) {
                                    element.classList.remove("show");
                                }
                            });
                        });
                    };

                    init();
                }

                bootnavbar();
            });
        </script>
        <?php
    }

    public function wp_nav_menu()
    {
        ?>
        <ul class="nav nav-pills col-12 col-lg-8 me-lg-auto mb-2 justify-content-center align-items-center mb-md-0">
            <?php foreach ( $this->navigation->all() as $item ) : ?>
                <?php
                $icon = get_post_meta( $item->id, '_menu_item_icon', true );
                $sidebar = get_post_meta($item->id, '_menu_item_sidebar', true);
                $icon_html = $icon ? '<i class="' . esc_attr($icon) . '"></i> ' : '';
                ?>

                <li class="<?php echo $item->classes; ?> nav-item <?php if ( $item->children || $sidebar ) : ?>dropdown<?php endif; ?>">

                    <a href="<?php echo $item->url; ?>"
                       class="nav-link <?php echo $item->active || $item->activeParent ? 'active' : ''; ?>
                       <?php if ( $item->children || $sidebar) : ?>dropdown-toggle<?php endif; ?>"
                    >
                        <?php echo $icon_html . $item->label; ?>
                    </a>

                   <?php if ($item->children || $sidebar) : $this->dropdown_menu($item, $sidebar); endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    public function dropdown_menu($item, $sidebar = null)
    {
        ?>
        <ul class="dropdown-menu">
        <?php foreach ($item->children ?? [] as $child) : ?>
            <li class="<?= $child->classes; ?> <?= $child->children ? 'dropdown' : '' ?> <?= $child->active ? 'current-item' : ''; ?>">

                <a href="<?= $child->url; ?>" class="dropdown-item <?= $child->children ? 'dropdown-toggle' : '' ?>">
                    <?php
                    $icon = get_post_meta( $child->id, '_menu_item_icon', true );
                    $icon_html = $icon ? '<i class="' . esc_attr($icon) . '"></i> ' : '';
                    ?>
                    <?php echo $icon_html . $child->label; ?>
                </a>

                <?php
                if ($child->children) :
                    $this->dropdown_menu($child);
                endif; ?>
            </li>
        <?php endforeach; ?>

        <?php
        if (!empty($sidebar)) {
            ob_start();
            dynamic_sidebar($sidebar);
            $sidebar_output = ob_get_clean();
            $output = '</li>';
            $output .= '<div class="sidebar">' . $sidebar_output . '</div>';
            $output .= '</li>';
            echo $output;
        }
        ?>

        </ul>
        <?php
    }

    public function my_wp_nav_menu_item_custom_fields( $item_id, $item, $depth, $args ) {
        ?>
        <p class="field-custom description description-wide">
            <label for="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>">
                <?php esc_html_e( 'Иконка:', 'textdomain' ); ?>
                <input type="text" id="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>"
                       name="menu-item-icon[<?php echo esc_attr( $item_id ); ?>]"
                       value="<?php echo esc_attr( get_post_meta( $item_id, '_menu_item_icon', true ) ); ?>" />
                <button class="button select-icon-button" data-target="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>">
                    <?php esc_html_e( 'Выбрать иконку', 'textdomain' ); ?>
                </button>
                <button class="button remove icon-minus" data-id="<?php echo esc_attr( $item_id ); ?>"></button>
            </label>
        </p>

        <div class="icon-modal" style="display:none;">
            <div class="icon-modal-content">
                <span class="close-modal">&times;</span>
                <h2><?php esc_html_e( 'Выберите иконку', 'textdomain' ); ?></h2>
                <div class="grid">
                    <?php
                    // Здесь мы выводим все иконки
                    foreach ( $this->icons as $icon ) {
                        echo '<div class="icon-item" data-icon="' . esc_attr( $icon ) . '">';
                        echo '<i class="' . esc_attr( $icon ) . '"></i>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <style>
            .icon-modal {
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.8);
            }
            .icon-modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 600px;
            }
            .close-modal {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
            }
            .wclose {
                color: rgb(250, 97, 108);
                font-size: 18px;
                font-weight: bold;
                line-height: 1;
                cursor: pointer;
            }
            .grid {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .icon-item {
                cursor: pointer;
                padding: 10px;
                border: 1px solid #ccc;
                text-align: center;
                transition: background-color 0.3s;
            }
            .icon-item:hover {
                background-color: #f0f0f0;
            }
        </style>

        <script>
            jQuery(document).ready(function($) {
                $('.select-icon-button').on('click', function(e) {
                    e.preventDefault();
                    $('.icon-modal').show();
                    // Сохраняем текущий input для использования позже
                    var targetInput = $(this).data('target');
                    $('.icon-item').data('targetInput', targetInput); // Сохраняем целевой input
                });

                $('.close-modal').on('click', function() {
                    $('.icon-modal').hide();
                });

                $('.icon-item').on('click', function() {
                    var selectedIcon = $(this).data('icon');
                    var targetInput = $(this).data('targetInput'); // Получаем целевой input
                    $('#' + targetInput).val(selectedIcon); // Устанавливаем значение в input
                    $('.icon-modal').hide();
                });

                $('.remove').on('click', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    $('#' + 'edit-menu-item-icon-' + id).val('');
                });

                $(window).on('click', function(event) {
                    if ($(event.target).is('.icon-modal')) {
                        $('.icon-modal').hide();
                    }
                });
            });
        </script>
        <?php
    }

    public function my_wp_update_nav_menu_item( $menu_id, $menu_item_db_id, $args ) {
        if ( isset( $_REQUEST['menu-item-icon'][$menu_item_db_id] ) ) {
            update_post_meta( $menu_item_db_id, '_menu_item_icon', sanitize_text_field( $_REQUEST['menu-item-icon'][$menu_item_db_id] ) );
        }

        if (!empty($_POST['menu-item-sidebar'][$menu_item_db_id])) {
            $sidebar = sanitize_text_field($_POST['menu-item-sidebar'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_menu_item_sidebar', $sidebar);
        } else {
            delete_post_meta($menu_item_db_id, '_menu_item_sidebar');
        }
    }

    public function my_wp_nav_menu_link_attributes( $atts, $item, $args ) {
        $icon = get_post_meta( $item->ID, '_menu_item_icon', true );
        if ( $icon ) {
            $atts['class'] .= ' menu-item-has-icon';
            $atts['data-icon'] = $icon;
        }
        return $atts;
    }

    public function choose_sidebar($item_id, $item, $depth, $args)
    {
        // Получаем все зарегистрированные сайдбары
        global $wp_registered_sidebars;

        // Получаем текущее значение сайдбара из метаданных
        $sidebar = get_post_meta($item_id, '_menu_item_sidebar', true);

        echo '<div class="field-sidebar">';
        echo '<label for="edit-menu-item-sidebar-' . $item_id . '">Выберите сайдбар:</label>';
        echo '<select id="edit-menu-item-sidebar-' . $item_id . '" name="menu-item-sidebar[' . $item_id . ']">';
            echo '<option value=""> - </option>';
            // Выводим список сайдбаров
            foreach ($wp_registered_sidebars as $sidebar_id => $sidebar_data) {
                $selected = ($sidebar === $sidebar_id) ? 'selected="selected"' : '';
                echo '<option value="' . esc_attr($sidebar_id) . '" ' . $selected . '>' . esc_html($sidebar_data['name']) . '</option>';
            }
        echo '</select>';
        echo '</div>';
    }
}
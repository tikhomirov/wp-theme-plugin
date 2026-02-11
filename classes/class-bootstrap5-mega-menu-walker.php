<?php


class Bootstrap5_Mega_Menu_Walker extends Walker_Nav_Menu
{
    function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        // Restores the more descriptive, specific name for use within this method.
        $menu_item = $data_object;

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
        $classes[] = 'menu-item-' . $menu_item->ID;

        /**
         * Фильтрует аргументы для одного элемента меню навигации.
         *
         * @since 4.4.0
         *
         * @param stdClass $args Объект аргументов wp_nav_menu().
         * @param WP_Post $menu_item Объект данных элемента меню.
         * @param int $depth Глубина элемента меню. Используется для заполнения.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );
        /**
         * Фильтрует классы CSS, применяемые к элементу списка элемента меню.
         *
         * @since 3.0.0
         * @since 4.1.0 Добавлен параметр `$depth`.
         *
         * @param string[] $classes Массив классов CSS, применяемых к элементу `<li>` элемента меню.
         * @param WP_Post $menu_item Текущий объект элемента меню.
         * @param stdClass $args Объект аргументов wp_nav_menu().
         * @param int $depth Глубина элемента меню. Используется для отступов.
         */
        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
        /**
         * Фильтрует атрибут ID, примененный к элементу списка элемента меню.
         *
         * @since 3.0.1
         * @since 4.1.0 Добавлен параметр `$depth`.
         *
         * @param string $menu_item_id Атрибут ID, примененный к элементу `<li>` элемента меню.
         * @param WP_Post $menu_item Текущий элемент меню.
         * @param stdClass $args Объект аргументов wp_nav_menu().
         * @param int $depth Глубина элемента меню. Используется для заполнения.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

        $li_atts          = array();
        $li_atts['id']    = ! empty( $id ) ? $id : '';
        $li_atts['class'] = ! empty( $class_names ) ? $class_names : '';

        /**
         * Фильтрует атрибуты HTML, применяемые к элементу списка пунктов меню.
         *
         * @since 6.3.0
         *
         * @param array $li_atts {
         * Атрибуты HTML, применяемые к элементу `<li>` пункта меню, пустые строки игнорируются.
         *
         * @type string $class HTML CSS-атрибут класса.
         * @type string $id HTML-атрибут идентификатора.
         * }
         * @param WP_Post $menu_item Текущий объект пункта меню.
         * @param stdClass $args Объект аргументов wp_nav_menu().
         * @param int $depth Глубина пункта меню. Используется для отступов.
         */
        $li_atts       = apply_filters( 'nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth );
        $li_attributes = $this->build_atts( $li_atts );

        $output .= $indent . '<li' . $li_attributes . '>';

        $atts           = array();
        $atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
        $atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
        if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $menu_item->xfn;
        }

        if ( ! empty( $menu_item->url ) ) {
            if ( get_privacy_policy_url() === $menu_item->url ) {
                $atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
            }

            $atts['href'] = $menu_item->url;
        } else {
            $atts['href'] = '';
        }

        $atts['aria-current'] = $menu_item->current ? 'page' : '';

        /**
         * Фильтрует атрибуты HTML, применяемые к якорному элементу пункта меню.
         *
         * @since 3.6.0
         * @since 4.1.0 Добавлен параметр `$depth`.
         *
         * @param array $atts {
         * Атрибуты HTML, применяемые к элементу `<a>` пункта меню, пустые строки игнорируются.
         *
         * @type string $title Атрибут заголовка.
         * @type string $target Атрибут цели.
         * @type string $rel Атрибут rel.
         * @type string $href Атрибут href.
         * @type string $aria-current Атрибут aria-current.
         * }
         * @param WP_Post $menu_item Объект текущего пункта меню.
         * @param stdClass $args Объект аргументов wp_nav_menu().
         * @param int $depth Глубина пункта меню. Используется для заполнения.
         */
        $atts       = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
        $attributes = $this->build_atts( $atts );

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

        /**
         * Фильтрует заголовок пункта меню.
         *
         * @since 4.4.0
         *
         * @param string $title Заголовок пункта меню.
         * @param WP_Post $menu_item Текущий объект пункта меню.
         * @param stdClass $args Объект аргументов wp_nav_menu().
         * @param int $depth Глубина пункта меню. Используется для заполнения.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

        $item_output  = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        /**
         * Фильтрует начальный вывод элемента меню.
         *
         * Начальный вывод элемента меню включает только `$args->before`, открывающий `<a>`,
         * заголовок элемента меню, закрывающий `</a>` и `$args->after`. В настоящее время нет
         * фильтра для изменения открывающего и закрывающего `<li>` для элемента меню.
         *
         * @since 3.0.0
         *
         * @param string $item_output Начальный вывод HTML элемента меню.
         * @param WP_Post $menu_item Объект данных элемента меню.
         * @param int $depth Глубина элемента меню. Используется для заполнения.
         * @param stdClass $args Объект аргументов wp_nav_menu().
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
    }

    /**
     * Отображение элемента
     *
     * Обходит элементы для создания списка из элементов.
     *
     * Отображает один элемент, если у элемента нет дочерних элементов, в противном случае
     * отображает элемент и его дочерние элементы. Обходит только до максимальной
     * глубины и не игнорирует элементы ниже этой глубины. Можно задать
     * максимальную глубину, чтобы включить все глубины, см. метод walk().
     *
     * Этот метод не следует вызывать напрямую, вместо этого используйте метод walk().
     *
     * @param object $element Объект данных.
     * @param array $children_elements Список элементов для продолжения обхода (передается по ссылке).
     * @param int $max_depth Максимальная глубина для обхода.
     * @param int $depth Глубина текущего элемента.
     * @param array $args Массив аргументов.
     * @param string $output Используется для добавления дополнительного содержимого (передается по ссылке).
     *
     *
     * @since 2.5.0
     *
     */
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args = [], &$output = '' )
    {
        //v($element);
        if ( !$element )
            return;

        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_array( $args[0] ) )
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        else if ( is_object( $args[0] ) )
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );


        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) )
        {
            foreach( $children_elements[ $id ] as $child )
            {
                if ( !isset($newlevel) )
                {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }

                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }

            unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel )
        {
            //end the child delimiter
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }



    /**
     * Отображает массив элементов иерархически.
     *
     * Не предполагает никакого существующего порядка элементов.
     *
     * $max_depth = -1 означает плоское отображение каждого элемента.
     * $max_depth = 0 означает отображение всех уровней.
     * $max_depth > 0 указывает количество уровней отображения.
     *
     * @since 2.1.0
     * @since 5.3.0 Формализован существующий параметр `...$args` путем добавления его
     * в сигнатуру функции.
     *
     * @param array $elements Массив элементов.
     * @param int $max_depth Максимальная иерархическая глубина.
     * @param mixed ...$args Необязательные дополнительные аргументы.
     * @return string Вывод иерархического элемента.
     */
    public function walk( $elements, $max_depth, ...$args ) {
        $output = '';

        $max_depth = (int) $max_depth;

        // Invalid parameter or nothing to walk.
        if ( $max_depth < -1 || empty( $elements ) ) {
            return $output;
        }

        $parent_field = $this->db_fields['parent'];

        // Flat display.
        if ( -1 === $max_depth ) {
            $empty_array = array();
            foreach ( $elements as $e ) {
                $this->display_element( $e, $empty_array, 1, 0, $args, $output );
            }
            return $output;
        }

        /*
         * Need to display in hierarchical order.
         * Separate elements into two buckets: top level and children elements.
         * Children_elements is two dimensional array. Example:
         * Children_elements[10][] contains all sub-elements whose parent is 10.
         */
        $top_level_elements = array();
        $children_elements  = array();
        foreach ( $elements as $e ) {
            if ( empty( $e->$parent_field ) ) {
                $top_level_elements[] = $e;
            } else {
                $children_elements[ $e->$parent_field ][] = $e;
            }
        }

        /*
         * When none of the elements is top level.
         * Assume the first one must be root of the sub elements.
         */
        if ( empty( $top_level_elements ) ) {

            $first = array_slice( $elements, 0, 1 );
            $root  = $first[0];

            $top_level_elements = array();
            $children_elements  = array();
            foreach ( $elements as $e ) {
                if ( $root->$parent_field === $e->$parent_field ) {
                    $top_level_elements[] = $e;
                } else {
                    $children_elements[ $e->$parent_field ][] = $e;
                }
            }
        }

        foreach ( $top_level_elements as $e ) {
            $this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
        }

        /*
         * If we are displaying all levels, and remaining children_elements is not empty,
         * then we got orphans, which should be displayed regardless.
         */
        if ( ( 0 === $max_depth ) && count( $children_elements ) > 0 ) {
            $empty_array = array();
            foreach ( $children_elements as $orphans ) {
                foreach ( $orphans as $op ) {
                    $this->display_element( $op, $empty_array, 1, 0, $args, $output );
                }
            }
        }

        return $output;
    }

}
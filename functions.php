<?php
add_action('wp_enqueue_scripts', 'mygoodwin_styles'); // подключаем стили
add_action('after_setup_theme', 'add_features');
add_action('after_setup_theme', 'add_menus');
add_action('wp_enqueue_scripts', 'mygoodwin_scripts');

function mygoodwin_styles() // подключаем стили
{
    wp_enqueue_style('mygoodwin-normolize', get_stylesheet_directory_uri() . '/assets/css/normolize.css'); // нормалайз
    wp_enqueue_style('mygoodwin-normolize', get_stylesheet_uri());
    wp_enqueue_style('mygoodwin-style', get_stylesheet_directory_uri() . '/assets/css/site.css'); // основные стили
}

function mygoodwin_scripts()
{
    wp_enqueue_script('mygoodwin-script', get_stylesheet_directory_uri() . '/assets/js/js.js', array(), '', true); // array() пустой — нет зависимостей, true — в футере
}

function add_features()
{
    add_theme_support('custom-logo', [
        'height' => 36,
        'width' => 160,
        'flex-width' => false,
        'flex-height' => false,
        'header-text' => '',
        'unlink-homepage-logo' => true,
    ]);
}
function add_menus()
{
    register_nav_menus([
        'header_main_menu' => 'Главное меню',
        'header_submenu' => 'Главное подменю',
        'footer_menu' => 'Меню в подвале',
    ]);
}

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="header__nav-item dropdown dropdown--open ' . esc_attr($class_names) . '"' : ' class="header__nav-item dropdown dropdown--open"';

        $output .= '<li' . $class_names . '>';
        $attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        if (in_array('menu-item-has-children', $classes)) {
            // Для родителей с вложенностью: с дивом и кнопкой
            $output .= '<div class="dropdown__wrap">';
            $output .= '<a class="header__nav-link link"' . $attributes . '>' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
            $output .= '<button class="dropdown__toggle"><span class="dropdown__caret"></span></button>';
            $output .= '</div>';
        } else {
            // Для листьев без вложенности: просто <a>
            $output .= '<a class="header__nav-link link"' . $attributes . '>' . apply_filters('the_title', $item->title, $item->ID) . '</a>';
        }
    }

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '<ul class="list-reset header__subnav-list dropdown__menu">';
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '</ul>';
    }
}

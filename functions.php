<?php
add_action('wp_enqueue_scripts', 'mygoodwin_styles'); // подключаем стили и скрипты
// add_action('after_setup_theme', 'add_features');
add_action('after_setup_theme', 'add_menus');
add_action('wp_enqueue_scripts', 'mygoodwin_scripts'); // подключаем стили и скрипты
add_action('customize_register', 'mygoodwin_customize_register');
wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'); // CSS Bootstrap для стилей (карусель, кнопки).
wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true); // JS Bootstrap для анимации (bundle включает Popper для стрелок). array('jquery') — зависимость от jQuery, WP его грузит. true — в футере, чтоб DOM готов был.



// Добавляем поддержку кастомных лого в Customizer
function mygoodwin_customize_register($wp_customize)
{
    // Секция для лого
    $wp_customize->add_section('mygoodwin_logos', array(
        'title' => 'Логотипы',
        'priority' => 30,
    ));

    // Поле для лого в шапке
    $wp_customize->add_setting('logo_header', array(
        'default' => get_template_directory_uri() . '/assets/img/logo-header.svg', // Твой дефолтный путь
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_header', array(
        'label' => 'Логотип для шапки (тёмный)',
        'section' => 'mygoodwin_logos',
        'settings' => 'logo_header',
    )));

    // Поле для лого в футере
    $wp_customize->add_setting('logo_footer', array(
        'default' => get_template_directory_uri() . '/assets/img/logo-footer.svg', // Твой дефолтный путь
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_footer', array(
        'label' => 'Логотип для футера (светлый)',
        'section' => 'mygoodwin_logos',
        'settings' => 'logo_footer',
    )));
}
function mygoodwin_styles() // подключаем стили
{
    wp_enqueue_style('mygoodwin-base', get_stylesheet_uri());
    wp_enqueue_style('mygoodwin-normolize', get_stylesheet_directory_uri() . '/assets/css/normolize.css'); // нормалайз
    wp_enqueue_style('mygoodwin-style', get_stylesheet_directory_uri() . '/assets/css/site.css'); // основные стили
    wp_enqueue_style('mygoodwin-footer', get_stylesheet_directory_uri() . '/assets/css/footer.css'); // footer
}

function mygoodwin_scripts() // подключаем стили
{
    wp_enqueue_script('mygoodwin-script', get_stylesheet_directory_uri() . '/assets/js/js.js', array(), '', true); // array() пустой — нет зависимостей, true — в футере
}


function add_menus()
{
    register_nav_menus([
        'header_main_menu' => 'Главное меню',
        'header_submenu_xl' => 'Главное подменю для ПК',
        'header_submenu_xs' => 'Главное подменю для мобильных',
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

add_action('wp_footer', 'debug_slider_full');
function debug_slider_full() {
    if (is_front_page()) {
        $slider = get_field('slide', get_the_ID());  // ACF get_field, не get_post_meta
        echo '<script>console.log("Slider data:", ' . json_encode($slider) . ');</script>';
    }
}
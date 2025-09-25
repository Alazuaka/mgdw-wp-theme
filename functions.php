<?php
add_action('wp_enqueue_scripts', 'mygoodwin_styles'); // подключаем стили и скрипты
// add_action('after_setup_theme', 'add_features');
add_action('after_setup_theme', 'add_menus');
add_action('wp_enqueue_scripts', 'mygoodwin_scripts'); // подключаем стили и скрипты
add_action('customize_register', 'mygoodwin_customize_register');
add_action('admin_enqueue_scripts', 'mygoodwin_slide_scripts'); // для карусели
add_action('save_post', 'mygoodwin_save_slide_meta');



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

// CPT для карусели
function mygoodwin_slider_cpt()
{
    register_post_type('slider_slide', [
        'labels' => ['name' => 'Слайды карусели', 'singular_name' => 'Слайд'],
        'public' => false,  // Не на фронте, только админка
        'show_ui' => true,
        'supports' => ['title'],  // Только заголовок для текста
        'menu_icon' => 'images-alt2',
    ]);
}
add_action('init', 'mygoodwin_slider_cpt');

// Meta box для слайдов
function mygoodwin_slide_meta_box()
{
    add_meta_box('slide_image_link', 'Изображение и ссылка', 'mygoodwin_slide_callback', 'slider_slide');
}
add_action('add_meta_boxes', 'mygoodwin_slide_meta_box');  // Мн.ч., чтоб WP не игнорил

function mygoodwin_slide_callback($post)
{
    wp_nonce_field('slide_nonce', 'slide_nonce');
    $img_id = get_post_meta($post->ID, 'slide_image', true);
    $link = get_post_meta($post->ID, 'slide_link', true);
    $img_html = '';
    if ($img_id) {
        $img_html = wp_get_attachment_image($img_id, 'large');
    } else {
        $img_html = '<p style="color:red;">Нет изображения</p>';
    }
    echo '<p><label>Изображение:</label><br>' . $img_html . '<br>' .
        '<input type="button" class="button" value="Выбрать" id="slide_img_btn"></p>' .
        '<input type="hidden" name="slide_image" id="slide_image" value="' . esc_attr($img_id) . '">';
    echo '<p><label>Ссылка:</label><br><input type="url" name="slide_link" value="' . esc_attr($link) . '" style="width:100%;"></p>';
}

// JS для медиа-аплоадера (в wp_head или enqueue)
function mygoodwin_slide_scripts($hook)
{
    $screen = get_current_screen();  // Правильно берём screen
    if ($screen->post_type !== 'slider_slide' || ($hook !== 'post.php' && $hook !== 'post-new.php')) return;
    wp_enqueue_media();
?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('slide_img_btn');
            const input = document.getElementById('slide_image');
            if (btn && input) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const uploader = wp.media({
                        title: 'Выбери картинку',
                        button: {
                            text: 'Вставить'
                        }
                    }).on('select', function() {
                        const attachment = uploader.state().get('selection').first().toJSON();
                        input.value = attachment.id;
                        // Удаляем старое превью, если есть
                        const oldPreview = btn.nextElementSibling;
                        if (oldPreview && oldPreview.tagName === 'IMG') oldPreview.remove();
                        // Новое
                        let preview = document.createElement('img');
                        preview.src = attachment.url;
                        preview.style.maxWidth = '200px';
                        preview.style.display = 'block';
                        preview.style.marginTop = '10px';
                        btn.parentNode.insertBefore(preview, btn.nextSibling);
                    }).open();
                });
            }
        });
    </script>
<?php
}

// Сохранение
function mygoodwin_save_slide_meta($post_id)
{
    if (!wp_verify_nonce($_POST['slide_nonce'], 'slide_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    update_post_meta($post_id, 'slide_image', intval($_POST['slide_image']));
    update_post_meta($post_id, 'slide_link', esc_url_raw($_POST['slide_link']));
}

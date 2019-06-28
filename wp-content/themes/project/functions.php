<?php
/*
 * Добавление поддержки функций
 * Добавление областей 'primary', 'footer'
 * Регистрация Сайдбара: Архивы и записи
 */

define('THEME', get_template_directory());
define('TPL', get_template_directory_uri());

define('DEVELOPMENT_ID', '94.181.95.199');

class ProjectTheme
{
    static function theme_setup()
    {
        // load_theme_textdomain( 'seo18theme', get_template_directory() . '/assets/languages' );

        add_theme_support( 'custom-logo' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array(
            'search-form',
            // 'comment-form',
            // 'comment-list',
            'gallery',
            'caption',
        ) );

        register_nav_menus( array(
            'primary' => 'Главное меню',
            'footer' => 'Меню в подвале',
        ) );
    }

    static function widgets()
    {
        register_sidebar( array(
            'name'          => 'Архивы и записи',
            'id'            => 'archive',
            'description'   => 'Эти виджеты показываются в архивах и остальных страницах',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }

    static function assets()
    {
        $is_compressed = ! defined('SCRIPT_DEBUG') || SCRIPT_DEBUG === false;
        $minify = $is_compressed ? '.min' : '';

        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), '3.4.1' );
        wp_enqueue_script( 'jquery' );

        wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '3.3.1' );

        /**
         * Bootstrap framework
         */
        wp_enqueue_script('bootstrap', TPL . '/assets/bootstrap'. $minify .'.js', array('jquery'), '4.1', true);
        wp_enqueue_style( 'bootstrap-style', TPL . '/assets/bootstrap'. $minify .'.css', array() );
        // */

        /**
         * Fancybox: Modal windows
         * /
        wp_enqueue_script('fancybox', TPL . '/assets/fancybox/jquery.fancybox.min.js', array('jquery'), '3', true);
        wp_enqueue_style( 'fancybox-style', TPL . '/assets/fancybox/jquery.fancybox.min.css', array() );
        // */

        /**
         * Slick: Slider
         * /
        wp_enqueue_script('slick', TPL . '/assets/slick/slick.min.js', array('jquery'), '1.8.1', true);
        wp_enqueue_style( 'slick-style', TPL . '/assets/slick/slick.css', array() );
        wp_enqueue_style( 'slick-theme', TPL . '/assets/slick/slick-theme.css', array() );
        // */

        wp_enqueue_style( 'hamburgers', TPL . '/assets/hamburgers'.$minify.'.css' );

        if( is_front_page() ) {
            $path = '/pages/index/style'.$minify.'.css';
            wp_enqueue_style( 'front-style', TPL . $path, array(), @filemtime( THEME . $path ) );
        }

        $path = '/template_styles'.$minify.'.css';
        wp_enqueue_style( 'style', TPL . $path, array(), @filemtime( THEME . $path ) );

        $path = '/assets/main'.$minify.'.js';
        wp_enqueue_script('script', TPL . $path, array('jquery'), @filemtime( THEME . $path ), true);
    }

    static function head_cleanup()
    {
        remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
        remove_action( 'wp_head', 'feed_links', 2 );                          // Post and Comment Feeds
        remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
        remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
        remove_action( 'wp_head', 'index_rel_link' );                         // index link
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
        remove_action( 'wp_head', 'wp_generator' );                           // WP version
    }
}

add_action('after_setup_theme',  array('ProjectTheme', 'theme_setup'));
add_action('widgets_init',       array('ProjectTheme', 'widgets'));
add_action('wp_enqueue_scripts', array('ProjectTheme', 'assets'), 999);
add_action('init',               array('ProjectTheme', 'head_cleanup'));

/**
 * Include required files
 * Редактировать дальше указанные файлы не рекомендуется, так как они обновляются, но..
 * Все классы и функции можно предопределить, объявив до подключения файла к примеру:
    function breadcrumbs_from_yoast() {
        yoast_breadcrumb('<div class="breadcrumbs">','</div>');
    }
 */

/************************ Template Actions and Filters ************************/
// add_action( 'theme_after_title', '_after_title' );
// function _after_title() {}

add_action( 'before_main_content', 'default_theme_nav', 10, 1 );
add_action( 'before_main_content', 'breadcrumbs_from_yoast', 10, 1 );

add_filter( 'content_columns', 'content_columns_default', 10, 1 );
function content_columns_default($columns) {
    if( is_singular() ) {
        $columns = 1;
    }

    return $columns;
}

/**
 * Development server attention
 */
add_action( 'wp_footer', 'local_attention' );
function local_attention() {
    if( is_local() ) {
        echo '<h3 id="development" style="position: fixed;bottom: 0;background-color: red;margin: 0;padding: 8px;">Это локальный сервер</h3>',
             '<script type="text/javascript">setTimeout(function() {document.getElementById("development").style.display = "none"}, 10000);</script>';
    }
}

require_once THEME . '/inc/post-type.php';
require_once THEME . '/inc/shortcode.php';

require THEME . '/inc/system/utilites.php';   // * Вспомогательные функции
require THEME . '/inc/system/admin.php';      // * Фильтры и функции административной части WP
require THEME . '/inc/system/tpl.php';        // * Основные функции вывода информации в шаблон
require THEME . '/inc/system/bootstrap.php';  // * Поддержка bootstrap framework 4.*
require THEME . '/inc/system/gallery.php';    // * Шаблон встроенной галереи wordpress

if( class_exists('woocommerce') ) {
    require THEME . '/woocommerce/functions.php';
    require THEME . '/inc/system/woocommerce.php';
    require THEME . '/inc/system/wc-customizer.php';
}

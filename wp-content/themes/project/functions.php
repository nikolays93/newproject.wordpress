<?php

if ( ! defined( 'THEME' ) ) {
	define( 'THEME', get_template_directory() );
}

if ( ! defined( 'TPL' ) ) {
	define( 'TPL', get_template_directory_uri() );
}

if ( ! defined( 'DEVELOPMENT_ID' ) ) {
	define( 'DEVELOPMENT_ID', '88.212.237.4' );
}

function enqueue_assets() {
	$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
	$min           = $is_compressed ? '.min' : '';

	/**
	 * jQuery required*
	 * @url https://jquery.com/
	 */
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(),
		'3.4.1' );
	wp_enqueue_script( 'jquery' );

	/**
	 * Modernizr. It can detect browser support
	 * @url https://modernizr.com/
	 */
	wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
		array(), '3.3.1' );

	/**
	 * Bootstrap framework
	 * @url https://getbootstrap.com/
	 */
	wp_enqueue_script( 'bootstrap', TPL . '/assets/vendor/bootstrap' . $min . '.js', array( 'jquery' ), '4.1',
		true );
	wp_enqueue_style( 'bootstrap-style', TPL . '/assets/vendor/bootstrap' . $min . '.css', array() );

	/**
	 * Hamburgers. Animated menu icons
	 */
	wp_enqueue_style( 'hamburgers', TPL . '/assets/vendor/hamburgers' . $min . '.css' );

	/**
	 * Fancy box. Modern modals
	 * @url http://fancyapps.com/
	 */
	// wp_enqueue_script('fancybox', TPL . '/assets/vendor/fancybox/jquery.fancybox.min.js', array('jquery'), '3', true);
	// wp_enqueue_style( 'fancybox-style', TPL . '/assets/vendor/fancybox/jquery.fancybox.min.css', array() );

	/**
	 * Slick. Easy slider
	 */
	// wp_enqueue_script('slick', TPL . '/assets/vendor/slick/slick.min.js', array('jquery'), '1.8.1', true);
	// wp_enqueue_style( 'slick-style', TPL . '/assets/vendor/slick/slick.css', array() );
	// wp_enqueue_style( 'slick-theme', TPL . '/assets/vendor/slick/slick-theme.css', array() );

	/**
	 * Cleave.js From inputs formatter
	 */
	// wp_enqueue_script('cleave', TPL . '/assets/vendor/cleave/slick.min.js', array('jquery'), '1.8.1', true);
}

/**
 * Custom post types (slider as example)
 */
require_once __DIR__ . '/inc/post-type.php';
require_once __DIR__ . '/inc/shortcode.php';
require_once __DIR__ . '/inc/widgets.php';

/**
 * Include required files
 * Редактировать файлы в папке system не рекомендуется, так как они обновляются, но..
 * Все классы и функции можно предопределить, объявив до подключения файла к примеру:
 * function breadcrumbs_by_yoast() { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); }
 */
require __DIR__ . '/inc/system/class-wp-bootstrap-navwalker.php';
require __DIR__ . '/inc/system/setup.php';      // *
require __DIR__ . '/inc/system/assets.php';     // * Дополнительные ресурсы
require __DIR__ . '/inc/system/utilites.php';   // * Вспомогательные функции
require __DIR__ . '/inc/system/admin.php';      // * Фильтры и функции административной части WP
require __DIR__ . '/inc/system/tpl.php';        // * Основные функции вывода информации в шаблон
require __DIR__ . '/inc/system/navigation.php'; // * Навигация
require __DIR__ . '/inc/system/gallery.php';    // * Шаблон встроенной галереи wordpress
require __DIR__ . '/inc/system/customizer.php'; // * Дополнительные функии в настройки внешнего вида
require __DIR__ . '/inc/system/wpcf7.php';      // * Дополнение к отправке почтовых сообщений

// Подключить поддержку "фишек" wordpress
add_action( 'after_setup_theme', 'theme_setup' );
// Очистить тэг head от излишек
add_action( 'init', 'head_cleanup' );

// Подключить скрипты и стили указанные в этом файле
add_action( 'wp_enqueue_scripts', 'enqueue_assets', 997 );
// Подлкючить скрипты и стили используемые шаблоном (на всем сайте)
add_action( 'wp_enqueue_scripts', 'enqueue_template_assets', 998 );
// Подлкючить скрипты и стили на данной (сейчас открытой) странице
add_action( 'wp_enqueue_scripts', 'enqueue_page_assets', 999 );

// добавляем bootstrap навигационное меню
add_action( 'before_main_content', 'bootstrap_navbar', 10, 1 );
// Добавляем мякиш от yoast
add_action( 'before_main_content', 'breadcrumbs_by_yoast', 10, 1 );

// Зарегистрировать виджеты из файла widgets.php
add_action( 'widgets_init', 'theme_widgets' );

// Регистрируем тип записи slide
add_action( 'init', 'register_type__slide' );
// Регистрируем таксономию slider
add_action( 'init', 'register_tax__slider' );
// Меняем местами ссылки на таксономию (Эта ссылка нужна первой) и тип записи
add_action( 'admin_menu', 'sort_menu_slider', 99 );
// Показываем принадлежащий слайдеру код вызова
add_filter( 'slider_row_actions', 'show_slider_shortcode', 10, 2 );
// Регистрируем шорткод для вывода элементов типа записи на странице таксономии
add_shortcode( 'slider', 'slider_shortcode' );

// Добавляем техническую информацию в письма Contact Form 7
add_action( 'wpcf7_before_send_mail', 'wpcf7_additional_info', 10, 3 );
add_filter( 'wpcf7_form_hidden_fields', 'wpcf7_post_id_field' );

if ( class_exists( 'woocommerce' ) ) {
	require __DIR__ . '/woocommerce/functions.php';
	require __DIR__ . '/inc/system/woocommerce.php';
	require __DIR__ . '/inc/system/wc-customizer.php';

	add_action( 'after_setup_theme', 'theme__woocommerce_support' );
	add_action( 'widgets_init', 'widget__woocommerce' );

	add_filter( 'woocommerce_enqueue_styles', 'theme__dequeue_styles' );

	add_filter( 'woocommerce_placeholder_img_src', 'placeholder__change_img_src' );

	// Yoast breadcrumbs instead woocommerce default
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	add_action( 'woocommerce_before_main_content', 'woo_breadcrumbs_by_yoast', 5 );

	/**
	 * Remove it after configuring (if need)
	 */
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

	add_filter( 'woocommerce_variable_sale_price_html', 'price__wc20_variation_format', 10, 2 );
	add_filter( 'woocommerce_variable_price_html', 'price__wc20_variation_format', 10, 2 );
	add_filter( 'woocommerce_currency_symbol', 'price__currency_symbol', 10, 2 );

	add_filter( 'woocommerce_default_address_fields', 'checkout__default_address_fields', 20, 1 );
	add_filter( 'woocommerce_checkout_fields', 'checkout__set_fields_priority', 15, 1 );
	add_filter( 'woocommerce_checkout_fields', 'checkout__add_fields_bootstrap_class', 15, 1 );

	add_filter( 'woocommerce_account_menu_items', 'account__menu_items' );
	add_filter( 'woocommerce_save_account_details_required_fields', 'account__required_inputs' );

	add_filter( 'wc_order_statuses', 'change_wc_order_statuses' );

	add_action( 'woocommerce_registration_redirect', 'logout_after_registration_redirect', 2 );

	add_filter( 'woocommerce_product_tabs', 'woo_change_tabs', 98 );
}

/**
 * Development server attention
 */
add_action( 'wp_footer', 'local_attention' );
function local_attention() {
	if ( function_exists( 'is_local' ) && is_local() ) {
		echo '<h3 id="development" style="position:fixed;bottom:32px;background-color:red;margin:0;padding:8px;">Это локальный сервер</h3>',
		'<script type="text/javascript">setTimeout(function(){document.getElementById("development").style.display="none"},10000);</script>';
	}
}

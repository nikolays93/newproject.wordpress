<?php

if ( ! defined( 'DEVELOPER_LINK' ) ) {
	// Ссылка на сайт производителя (разработчика сайта/темы)
	define( 'DEVELOPER_LINK', '//seo18.ru' );
}

if ( ! defined( 'DEVELOPER_NAME' ) ) {
	// Название производителя (разработчика)
	define( 'DEVELOPER_NAME', 'SEO18' );
}

if ( ! defined( 'DEVELOPER_TESTMAIL' ) ) {
	// Название производителя (разработчика)
	define( 'DEVELOPER_TESTMAIL', 'trashmailsizh@yandex.ru' );
}

if ( ! defined( 'DEVELOPMENT_IP' ) ) {
	// IP тестового сервера
	define( 'DEVELOPMENT_IP', '88.212.237.4' );
}

if ( ! defined( 'THEME' ) ) {
	// Путь на сервере до папки шаблона (с завершающим слэшем)
	define( 'THEME', get_template_directory() . DIRECTORY_SEPARATOR );
}

if ( ! defined( 'TPL' ) ) {
	// Ссылка на страницу папки шаблона
	define( 'TPL', get_template_directory_uri() . '/' );
}

if ( ! function_exists( 'require_path' ) ) {
	/**
	 * @param string $path path to required file
	 *
	 * @return void
	 */
	function require_path( $path ) {
		require __DIR__ . $path;
	}
}

/**
 * Include classes
 */
array_map( 'require_path', array(
	'/inc/class/wp-bootstrap-navwalker.php',
	'/inc/class/sms.ru.php',
	'/inc/class/sms-provider.php',
) );

/**
 * Include custom files
 */
array_map( 'require_path', array(
	'/inc/assets.php',     // * Дополнительные ресурсы
	'/inc/post-types.php', // * Функции добавления типа записи slide
	'/inc/shortcodes.php', // * Функции добавления шорткода
	'/inc/widgets.php',    // * Сайдбар панели (Виджеты)
) );

// Регистрируем тип записи слайдер "slide" (для примера)
add_action( 'init', 'register_type__slide' );
// Регистрируем таксономию slider
add_action( 'init', 'register_tax__slider' );
// Меняем местами ссылки на таксономию (Эта ссылка нужна первой) и тип записи
add_action( 'admin_menu', 'sort_menu_slider', 99 );
// Показываем принадлежащий слайдеру код вызова
add_filter( 'slider_row_actions', 'show_slider_shortcode', 10, 2 );
// Регистрируем шорткод для вывода элементов типа записи с помощью квадратных скобок [slider]
add_shortcode( 'slider', 'slider_shortcode' );

/**
 * Include required files
 * Редактировать файлы в папке system не рекомендуется, так как они обновляются, но..
 * Все классы и функции можно предопределить, объявив до подключения файла к примеру:
 * function breadcrumbs_by_yoast() { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); }
 */
array_map( 'require_path', array(
	'/inc/system/setup.php',         // *
	'/inc/system/utilites.php',      // * Вспомогательные функции
	'/inc/system/admin.php',         // * Фильтры и функции административной части WP
	'/inc/system/tpl.php',           // * Основные функции вывода информации в шаблон
	'/inc/system/navigation.php',    // * Навигация
	'/inc/system/gallery.php',       // * Шаблон встроенной галереи wordpress
	'/inc/system/customizer.php',    // * Дополнительные функии в настройки внешнего вида
	'/inc/system/notifications.php', // * Дополнение к отправке уведомлений
) );


// Подключить поддержку "фишек" wordpress
add_action( 'after_setup_theme', 'theme_setup' );
// Зарегистрировать стандартное меню (В шапке/в подвале, ./inc/system/navigation.php)
add_action( 'after_setup_theme', 'register_theme_navigation' );
// Зарегистрировать виджеты из файла ./inc/widgets.php
add_action( 'widgets_init', 'theme_widgets' );
// Очистить тэг head от излишек
add_action( 'init', 'head_cleanup' );
// Убрать заголовок Архивы: или Категория: в заголовке страницы списка записей
add_filter( 'get_the_archive_title', 'theme_archive_title_filter', 10, 1 );

// Подключить скрипты и стили указанные в этом файле
add_action( 'wp_enqueue_scripts', 'enqueue_assets', 997 );
// Подлкючить скрипты и стили используемые шаблоном (на всем сайте)
add_action( 'wp_enqueue_scripts', 'enqueue_template_assets', 998 );
// Подлкючить скрипты и стили на данной (сейчас открытой) странице
add_action( 'wp_enqueue_scripts', 'enqueue_page_assets', 999 );

// Добавляем bootstrap навигационное меню
add_action( 'before_main_content', 'bootstrap_navbar', 10, 1 );
// Добавляем мякиш от yoast
add_action( 'before_main_content', 'breadcrumbs_by_yoast', 10, 1 );


// Добавляем техническую информацию в письма Contact Form 7
add_action( 'wpcf7_before_send_mail', 'wpcf7_additional_info', 10, 3 );
add_filter( 'wpcf7_form_hidden_fields', 'wpcf7_post_id_field' );

if ( class_exists( 'woocommerce' ) ) {
	array_map( 'require_path', array(
		'/woocommerce/functions.php',    // *
		'/inc/system/woocommerce.php',   // *
		'/inc/system/wc-customizer.php', // *
	) );

	// Подключаем поддержку Woocommerce
	add_action( 'after_setup_theme', 'theme__woocommerce_support' );

	// Регистрируем сайдбар на страницах Woocommerce
	add_action( 'widgets_init', 'widget__woocommerce' );
	// Отключаем стандартные стили Woocommerce (Что бы использовать свои)
	add_filter( 'woocommerce_enqueue_styles', 'theme__dequeue_styles' );

	// Меняем ссылку на "не установленное" изображение (placeholder)
	add_filter( 'woocommerce_placeholder_img_src', 'placeholder__change_img_src' );

	// Yoast мякиш вместо стандартного woocommerce
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	add_action( 'woocommerce_before_main_content', 'woo_breadcrumbs_by_yoast', 5 );

	// Кол-во товаров на странице
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	// Сортировка каталога
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

	// Форматирование стоимости вариативного товара "От 100 руб." вместо стандартного "от 100 руб. до 111 руб."
	add_filter( 'woocommerce_variable_sale_price_html', 'price__wc20_variation_format', 10, 2 );
	add_filter( 'woocommerce_variable_price_html', 'price__wc20_variation_format', 10, 2 );
	// Меняем символ рубля (так как поддерживается не всеми браузерами) на руб.
	add_filter( 'woocommerce_currency_symbol', 'price__currency_symbol', 10, 2 );

	// Меняем поля ввода адреса (адрес аккаунта в том числе)
	add_filter( 'woocommerce_default_address_fields', 'checkout__default_address_fields', 20, 1 );
	// Меняем приоритеты полей подтверждения заказа
	add_filter( 'woocommerce_checkout_fields', 'checkout__set_fields_priority', 15, 1 );
	// Добавляем form-control (bootstrap класс) элементам формы
	add_filter( 'woocommerce_checkout_fields', 'checkout__add_fields_bootstrap_class', 15, 1 );

	// Удаляем неиспользуемые разделы аккаунта
	add_filter( 'woocommerce_account_menu_items', 'account__menu_items' );
	// Ввод имени/фамилии не обязателен
	add_filter( 'woocommerce_save_account_details_required_fields', 'account__required_inputs' );

	// Устанавливаем статус "Оплачен" после завершения заказа (Выполнен - вводит в заблуждение)
	add_filter( 'wc_order_statuses', 'change_wc_order_statuses' );
	// Не авторизуем новых пользователей (просим авторизироваться самостоятельно после регистрации)
	add_action( 'woocommerce_registration_redirect', 'logout_after_registration_redirect', 2 );
	// Меняем вкладки информационной панели (в файле ./woocommerce/functions.php)
	add_filter( 'woocommerce_product_tabs', 'change_wc_single_tabs', 98 );
	// Отправить СМС оповещение при создании нового заказа
	// add_action( 'woocommerce_new_order', 'woocommerce_new_order_send_sms' );
	// Отправлять техническое сообщение о новом заказе разработчику
	add_filter( 'woocommerce_email_headers', 'woocommerce__testmail', 10, 2);
	// Валидация номера телефона при совершении заказа
	add_action( 'woocommerce_after_checkout_validation', 'checkout__validate_billing_phone', 10, 2 );
}

/**
 * Development server attention
 */
add_action( 'wp_footer', function () {
	if ( function_exists( 'is_local' ) && is_local() ) {
		echo '<h3 id="development" style="position:fixed;bottom:32px;background-color:red;margin:0;padding:8px;">Это локальный сервер</h3>',
		'<script type="text/javascript">setTimeout(function(){document.getElementById("development").style.display="none"},10000);</script>';
	}
} );

// change default wordpress to custom authentication
remove_filter( 'authenticate', 'wp_authenticate_username_password', 20 );
add_filter( 'authenticate', 'wp_authenticate_username_phone_password', 20, 3 );

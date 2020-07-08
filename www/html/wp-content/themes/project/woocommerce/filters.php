<?php

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
add_filter( 'woocommerce_email_headers', 'woocommerce__testmail', 10, 3 );
// Валидация номера телефона при совершении заказа
add_action( 'woocommerce_after_checkout_validation', 'checkout__validate_billing_phone', 10, 2 );

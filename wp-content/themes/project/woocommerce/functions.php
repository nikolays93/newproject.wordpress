<?php
/*
 * @Override
 */
function wc_theme_dequeue_styles( $enqueue_styles ) {
    // unset( $enqueue_styles['woocommerce-general'] );     // Отключение общих стилей
    // unset( $enqueue_styles['woocommerce-layout'] );      // Отключение стилей шаблонов
    // unset( $enqueue_styles['woocommerce-smallscreen'] ); // Отключение оптимизации для маленьких экранов

    return $enqueue_styles;
}

/********************** Woocommerce Actions and Filters ***********************/
/**
 * Yoast breadcrumbs instead woocommerce default
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_main_content', 'woo_breadcrumbs_from_yoast', 5 );

/**
 * Remove it after configuring (if need)
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

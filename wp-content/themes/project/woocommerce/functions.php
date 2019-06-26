<?php

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
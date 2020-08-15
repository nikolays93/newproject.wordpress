<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Change the post_class function classes.
add_filter( 'post_class', 'add_theme_post_class', 10, 3 );
// Allow click base navbar item (for dropdowns).
apply_filters( 'nav_menu_link_attributes', 'nav_menu_link_allow_click', 10, 4 );

if ( ! function_exists( 'add_theme_post_class' ) ) {
	function add_theme_post_class( $classes, $class, $post_id ) {
		if ( is_archive() ) {
			/** @var int $columns Default columns count */
			$columns = (int) apply_filters( 'content_columns', 4 );
			// Insert classes in results on start.
			array_unshift(
				$classes,
				function_exists( 'get_default_bs_columns' ) ?
				get_default_bs_columns( $columns ) : 'columns-' . $columns
			);
		}

		return $classes;
	}
}

if ( ! function_exists( 'nav_menu_link_allow_click' ) ) {
	function nav_menu_link_allow_click( $atts, $item, $args, $depth ) {
		if ( get_theme_mod( 'allow_click', false ) ) {
			unset( $atts['data-toggle'] );
		}

		return $atts;
	}
}

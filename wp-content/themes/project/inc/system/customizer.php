<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'post_class', 'add_theme_post_class', 10, 3 );
if ( ! function_exists( 'add_theme_post_class' ) ) {
	function add_theme_post_class( $classes, $class, $post_id ) {
		if ( 'product' !== get_post_type() ) {
			if ( is_singular() ) {
				$columns = apply_filters( 'single_content_columns', 1 );
			} else {
				$columns = apply_filters( 'content_columns', 1 );
			}

			array_unshift( $classes, function_exists( 'get_default_bs_columns' ) ?
				get_default_bs_columns( (int) $columns ) : 'columns-' . (int) $columns );
		}

		return $classes;
	}
}

apply_filters( 'nav_menu_link_attributes', 'nav_menu_link_allow_click', 10, 4 );
if ( ! function_exists( 'nav_menu_link_allow_click' ) ) {
	function nav_menu_link_allow_click( $atts, $item, $args, $depth ) {
		if ( get_theme_mod( 'allow_click', false ) ) {
			unset( $atts['data-toggle'] );
		}

		return $atts;
	}
}

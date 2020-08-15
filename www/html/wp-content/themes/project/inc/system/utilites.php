<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'get_current_ip' ) ) {
	function get_current_ip() {
		return ( empty( $_SERVER['HTTP_CLIENT_IP'] ) && empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ?
			$_SERVER['REMOTE_ADDR'] : empty( $_SERVER['HTTP_CLIENT_IP'] ) ?
			$_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['HTTP_CLIENT_IP'];
	}
}

/**
 * It's development server
 */
if ( ! function_exists( 'is_local' ) ) {
	function is_local() {
		return ! empty( $_SERVER['SERVER_ADDR'] ) && in_array(
			$_SERVER['SERVER_ADDR'],
			array( '127.0.0.1', defined( 'DEVELOPMENT_ID' ) ? DEVELOPMENT_IP : '' ),
			true
		);
	}
}

/**
 * Мякиш от yoast SEO ( установить/активировать плагин, дополнительно => breadcrumbs )
 *
 * @link https://wordpress.org/plugins/wordpress-seo/
 */
if ( ! function_exists( 'breadcrumbs_by_yoast' ) ) {
	function breadcrumbs_by_yoast( $container = true ) {
		$is_woocommerce = function_exists( 'is_woocommerce' ) && is_woocommerce();

		if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() && $is_woocommerce ) {
			yoast_breadcrumb( '<div class="container"><p id="breadcrumbs">', '</p></div>' );
		}
	}
}

if ( ! function_exists( 'woo_breadcrumbs_by_yoast' ) ) {
	function woo_breadcrumbs_by_yoast( $container = true ) {
		if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() ) {
			yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
		}
	}
}

/**
 * Get full depth post ID (after front page)
 */
if ( ! function_exists( 'get_parent_page_id' ) ) {
	function get_parent_page_id( $post ) {
		if ( $post->post_parent ) {
			$ancestors = get_post_ancestors( $post->ID );
			$parent    = $ancestors[ count( $ancestors ) - 1 ];
		} else {
			$parent = $post->ID;
		}

		return $parent;
	}
}

/**
 * Check sub terms exists
 */
if ( ! function_exists( 'has_children_terms' ) ) {
	function has_children_terms( $hide_empty = true ) {
		$o = get_queried_object();

		if ( ! empty( $o->has_archive ) && $o->has_archive == true ) {
			$tax    = $o->taxonomies[0];
			$parent = 0;
		}

		if ( ! empty( $o->term_id ) ) {
			$tax    = $o->taxonomy;
			$parent = $o->term_id;
		}

		$children = get_terms(
			array(
				'taxanomy'   => $tax,
				'parent'     => $parent,
				'hide_empty' => $hide_empty,
				'number'     => 1,
			)
		);

		if ( $children ) {
			return true;
		}

		return false;
	}
}

/**
 * Вернет объект таксономии если на странице есть категории товара
 *
 * @param string $taxonomy название таксаномии (Не уверен что логично изменять)
 *
 * @return array  ids дочерних категорий
 */
if ( ! function_exists( 'get_children_product_terms' ) ) {
	function get_children_product_terms( $taxonomy = 'product_cat' ) {
		$children = array();
		if ( is_shop() && ! is_search() ) {
			$results = get_terms( $taxonomy );

			if ( ! is_wp_error( $results ) ) {
				foreach ( $results as $term ) {
					$children[] = $term->term_id;
				}
			}
		} else {
			$current = get_queried_object();

			if ( ! empty( $current->term_id ) ) {

				$children = get_term_children( $current->term_id, $taxonomy );
				if ( is_wp_error( $children ) ) {
					$children = array();
				}
			}
		}

		return $children;
	}
}

if ( ! function_exists( 'the_thumbnail' ) ) {
	function the_thumbnail( $post_id = false, $add_link = false ) {
		if ( 0 >= $post_id = absint( $post_id ) ) {
			$post_id = get_the_id();
		}

		if ( is_singular() ) {
			$thumbnail = get_the_post_thumbnail(
				$post_id,
				apply_filters( 'content_full_image_size', 'medium' ),
				apply_filters( 'content_full_image_args', array( 'class' => 'al' ) )
			);
		} else {
			$thumbnail = get_the_post_thumbnail(
				$post_id,
				apply_filters( 'content_thumbnail_size', 'thumbnail' ),
				apply_filters( 'content_thumbnail_args', array( 'class' => 'al' ) )
			);
		}

		if ( $add_link ) {
			$thumbnail = add_thumbnail_link( $thumbnail, $post_id );
		}

		$thumbnail_html = apply_filters( 'content_image_html', $thumbnail, $post_id, $add_link );

		echo $thumbnail_html;
	}
}

/**
 * Получить стандартные классы ячейки bootstrap сетки
 */
if ( ! function_exists( 'get_default_bs_columns' ) ) {
	function get_default_bs_columns( $columns_count = 4, $non_responsive = false ) {
		switch ( $columns_count ) {
			case '1':
				$col = 'col-12';
				break;
			case '2':
				$col = ( ! $non_responsive ) ? 'col-6 col-sm-6 col-md-6 col-lg-6' : 'col-6';
				break;
			case '3':
				$col = ( ! $non_responsive ) ? 'col-12 col-sm-6 col-md-4 col-lg-4' : 'col-4';
				break;
			case '4':
				$col = ( ! $non_responsive ) ? 'col-6 col-sm-4 col-md-3 col-lg-3' : 'col-3';
				break;
			case '5':
				$col = ( ! $non_responsive ) ? 'col-12 col-sm-6 col-md-2-4 col-lg-2-4' : 'col-2-4';
				break; // be careful
			case '6':
				$col = ( ! $non_responsive ) ? 'col-6 col-sm-4 col-md-2 col-lg-2' : 'col-2';
				break;
			case '12':
				$col = ( ! $non_responsive ) ? 'col-4 col-sm-3 col-md-1 col-lg-1' : 'col-1';
				break;

			default:
				$col = false;
				break;
		}

		return apply_filters( 'get_default_bs_columns', $col, $columns_count, $non_responsive );
	}
}

if ( ! function_exists( 'get_validate_phone_pattern' ) ) {
	/**
	 * Validate russian phone number (for billing phone)
	 *
	 * @return string
	 */
	function get_validate_phone_pattern() {
		$pattern = '^((8|\+7)[\- ]?)?(\(?\d{3,5}\)?[\- ]?)?[\d\- ]{7,10}$';

		return $pattern;
	}
}

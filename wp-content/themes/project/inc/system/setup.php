<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! function_exists( 'theme_setup' ) ) {
	function theme_setup() {
		load_theme_textdomain( 'project', get_template_directory() . '/languages' );

		add_theme_support( 'custom-logo' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'gallery',
		) );
	}
}

if( ! function_exists( 'head_cleanup' ) ) {
	function head_cleanup() {
		remove_action( 'wp_head', 'feed_links_extra', 3 );                 // Category Feeds
		remove_action( 'wp_head', 'feed_links', 2 );                       // Post and Comment Feeds
		remove_action( 'wp_head', 'rsd_link' );                            // EditURI link
		remove_action( 'wp_head', 'wlwmanifest_link' );                    // Windows Live Writer
		remove_action( 'wp_head', 'index_rel_link' );                      // index link
		remove_action( 'wp_head', 'parent_post_rel_link', 10 );            // previous link
		remove_action( 'wp_head', 'start_post_rel_link', 10 );             // start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); // Links for Adjacent Posts
		remove_action( 'wp_head', 'wp_generator' );                        // WP version
	}
}

if( ! function_exists( 'disable_emojis' ) ) {
	function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
		add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
	}
}

if( ! function_exists( 'disable_emojis_tinymce' ) ) {
	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 *
	 * @param array $plugins
	 * @return array Difference betwen the two arrays
	 */
	function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}
}

if( ! function_exists( 'disable_emojis_remove_dns_prefetch' ) ) {
	/**
	 * Remove emoji CDN hostname from DNS prefetching hints.
	 *
	 * @param array $urls URLs to print for resource hints.
	 * @param string $relation_type The relation type the URLs are printed for.
	 * @return array Difference betwen the two arrays.
	 */
	function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
		if ( 'dns-prefetch' == $relation_type ) {
			/** This filter is documented in wp-includes/formatting.php */
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

			$urls = array_diff( $urls, array( $emoji_svg_url ) );
		}

		return $urls;
	}
}

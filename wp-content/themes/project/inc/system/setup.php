<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

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

function head_cleanup() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );                 // Category Feeds
	remove_action( 'wp_head', 'feed_links', 2 );                       // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                                   // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                           // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                             // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10 );            // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10 );             // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator' );                               // WP version
}

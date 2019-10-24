<?php
/*
Template Name: Sidebar next page
Template Post Type: page
*/

add_action( 'site_after_main_row_content', 'the_sidebar' );

add_filter( 'site_sidebar_class', function () {
	return 'site-sidebar col-12 col-lg-3';
} );
add_filter( 'site_primary_class', function () {
	return 'site-primary col-12 col-lg-9';
} );

$path = realpath( __DIR__ . '/../page.php' );
if ( ! file_exists( $path ) ) {
	$path = realpath( __DIR__ . '/../index.php' );
}

include $path;

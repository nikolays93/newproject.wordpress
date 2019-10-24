<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function enqueue_template_assets() {
	$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
	$min           = $is_compressed ? '.min' : '';

	/**
	 * Enqueue styles
	 */
	$path = 'assets/template' . $min . '.css';
	if ( file_exists( THEME . $path ) ) {
		wp_enqueue_style( 'style', TPL . $path, array(), @filemtime( THEME . $path ) );
	}

	/**
	 * Enqueue scripts
	 */
	$path = 'assets/main' . $min . '.js';
	if ( file_exists( THEME . $path ) ) {
		wp_enqueue_script( 'script', TPL . $path, array( 'jquery' ), @filemtime( THEME . $path ), true );
	}
}

function enqueue_page_assets() {
	$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
	$min           = $is_compressed ? '.min' : '';

	// define current page path (for used later ./pages/index/style.css as example)
	$curDir = is_front_page() ? 'index' : get_page_uri();

	/**
	 * Enqueue current page style
	 */
	$stylePath = "pages/$curDir/style$min.css";
	if ( file_exists( THEME . $stylePath ) ) {
		wp_enqueue_style( 'page-style', TPL . $stylePath, array(), @filemtime( THEME . $stylePath ) );
	}

	/**
	 * Enqueue current page script
	 */
	$scriptPath = "pages/$curDir/script$min.js";
	if ( file_exists( THEME . $scriptPath ) ) {
		wp_enqueue_script( 'page-script', TPL . $scriptPath, array( 'jquery' ), @filemtime( THEME . $scriptPath ),
			true );
	}
}
<?php

if ( ! function_exists( 'enqueue_assets' ) ) {
	/**
	 * Import dependences (include css/js vendor files to site)
	 * @return void
	 */
	function enqueue_assets() {
		$is_compressed = ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false;
		$min           = $is_compressed ? '.min' : '';

		/**
		 * jQuery required*
		 * @url https://jquery.com/
		 */
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(),
			'3.4.1' );
		wp_enqueue_script( 'jquery' );

		/**
		 * Modernizr. It can detect browser support
		 * @url https://modernizr.com/
		 */
		wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
			array(), '3.3.1' );

		/**
		 * Bootstrap framework
		 * @url https://getbootstrap.com/
		 */
		wp_enqueue_script( 'bootstrap', TPL . 'assets/vendor/bootstrap' . $min . '.js', array( 'jquery' ), '4.1',
			true );
		wp_enqueue_style( 'bootstrap-style', TPL . 'assets/vendor/bootstrap' . $min . '.css', array() );

		/**
		 * Hamburgers. Animated menu icons
		 * @url https://jonsuh.com/hamburgers/
		 */
		wp_enqueue_style( 'hamburgers', TPL . 'assets/vendor/hamburgers' . $min . '.css' );

		/**
		 * Fancy box. Modern modals
		 * @url http://fancyapps.com/
		 */
		// wp_enqueue_script('fancybox', TPL . 'assets/vendor/fancybox/jquery.fancybox.min.js', array('jquery'), '3', true);
		// wp_enqueue_style( 'fancybox-style', TPL . 'assets/vendor/fancybox/jquery.fancybox.min.css', array() );

		/**
		 * Slick. Easy slider
		 * @url https://kenwheeler.github.io/slick/
		 */
		// wp_enqueue_script('slick', TPL . 'assets/vendor/slick/slick.min.js', array('jquery'), '1.8.1', true);
		// wp_enqueue_style( 'slick-style', TPL . 'assets/vendor/slick/slick.css', array() );
		// wp_enqueue_style( 'slick-theme', TPL . 'assets/vendor/slick/slick-theme.css', array() );

		/**
		 * Cleave.js form inputs mask formatter
		 * @url https://nosir.github.io/cleave.js/
		 */
		// wp_enqueue_script( 'cleave', TPL . 'assets/vendor/cleave/cleave.min.js', array(), false, true );
		// wp_enqueue_script( 'cleave-phone', TPL . 'assets/vendor/cleave/addons/cleave-phone.ru.js', array(), false, true );
	}
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
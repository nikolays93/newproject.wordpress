<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'register_theme_navigation' ) ) {
	function register_theme_navigation() {
		register_nav_menus( array(
			'primary' => __( 'Главное меню', 'project' ),
			'footer'  => __( 'Меню в подвале', 'project' ),
		) );
	}
}

if ( ! function_exists( 'bootstrap_navbar' ) ) {
	function bootstrap_navbar( $args = array(), $before = '<div class="container">', $after = '</div>' ) {

		$args = wp_parse_args( $args, array(
			'brand'           => get_custom_logo(),
			'container_id'    => 'default-collapse',
			'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
			'togglerClass'    => 'hamburger hamburger--elastic',
			'sectionClass'    => 'site-navigation navbar-default',
			'navClass'        => 'navbar navbar-expand-lg navbar-light bg-light',
		) );

		if ( ! $args['brand'] ) {
			$args['brand'] = sprintf(
				'<a class="navbar-brand hidden-lg-up text-center" title="%s" href="%s">%s</a>',
				get_bloginfo( "description" ),
				get_bloginfo( 'url' ),
				get_bloginfo( "name" )
			);
		}

		printf( '<section class="%s"><nav class="%s">%s',
			esc_attr( $args['sectionClass'] ),
			esc_attr( $args['navClass'] ),
			$before
		);

		if ( $args['togglerClass'] ) :
			// default bootstrap toggler
			// <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#'.$args['container_id'].'">
			//     <span class="navbar-toggler-icon"></span>
			// </button>
			?>
			<button type="button"
					class="navbar-toggler <?= $args['togglerClass'] ?>"
					data-toggle="collapse"
					data-target="#<?= $args['container_id'] ?>"
					aria-controls="<?= $args['container_id'] ?>"
					aria-expanded="false"
					aria-label="Toggle navigation">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
		<?php
		endif;

		echo $args['brand'];
		bootstrap_nav( $args );
		printf( '%s</nav></section>', $after );
	}
}

if ( ! function_exists( 'bootstrap_nav' ) ) {
	function bootstrap_nav( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'menu'           => 'main_nav',
			'menu_class'     => 'nav navbar-nav',
			'theme_location' => 'primary',
			'walker'         => new WP_Bootstrap_Navwalker(),
		) );

		wp_nav_menu( $args );
	}
}

if ( ! function_exists( 'footer_links' ) ) {
	function footer_links( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'menu'            => 'footer_links',
			'theme_location'  => 'footer',
			'container_class' => 'footer clearfix',
		) );

		wp_nav_menu( $args );
	}
}

if ( ! function_exists( 'the_template_pagination' ) ) {
	function the_template_pagination( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'show_all'  => false,
			'end_size'  => 1,
			'mid_size'  => 1,
			'prev_next' => true,
			'prev_text' => __( '« Пред.', 'project' ),
			'next_text' => __( 'След. »', 'project' ),
			'add_args'  => false,
		) );

		the_posts_pagination( $args );
	}
}

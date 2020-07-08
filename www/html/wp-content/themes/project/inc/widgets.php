<?php

if ( ! function_exists( 'theme_widgets' ) ) {
	function theme_widgets() {
		register_sidebar( array(
			'name'          => __( 'Архивы и записи', 'project' ),
			'id'            => 'archive',
			'description'   => __( 'Эти виджеты показываются в архивах' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => __( 'Страницы', 'project' ),
			'id'            => 'page',
			'description'   => __( 'Эти виджеты показываются на страницах' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}

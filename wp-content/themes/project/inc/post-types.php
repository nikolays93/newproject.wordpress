<?php

if ( ! function_exists( 'register_type__slide' ) ) {
	function register_type__slide() {
		$labels = array(
			'name'               => __( 'Слайды', 'project' ),
			'singular_name'      => __( 'Слайд', 'project' ),
			'add_new'            => __( 'Добавить слайд', 'project' ),
			'add_new_item'       => __( 'Добавить слайд', 'project' ),
			'edit_item'          => __( 'Редактировать слайд', 'project' ),
			'new_item'           => __( 'Новый слайд', 'project' ),
			'all_items'          => __( 'Все слайды', 'project' ),
			'view_item'          => __( 'Просмотр слайда на сайте', 'project' ),
			'search_items'       => __( 'Найти слайд', 'project' ),
			'not_found'          => __( 'Слайдов не найдено.', 'project' ),
			'not_found_in_trash' => __( 'В корзине нет слайдов.', 'project' ),
			'menu_name'          => __( 'Слайды', 'project' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'publicly_queryable'  => null,
			'exclude_from_search' => null,
			'show_ui'             => null,
			'show_in_menu'        => null,
			'show_in_admin_bar'   => null,
			'show_in_nav_menus'   => null,
			'menu_icon'           => 'dashicons-images-alt2',
			'menu_position'       => 15,
			'has_archive'         => true,
			'hierarchical'        => false,
			// 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			// 'taxonomies' => array('post_tag'),
			'description'         => '',
		);

		register_post_type( 'slide', $args );
	}
}

if ( ! function_exists( 'register_tax__slider' ) ) {
	function register_tax__slider() {
		$labels = array(
			'name'                       => __( 'Слайдер', 'project' ),
			'singular_name'              => __( 'Слайдер', 'project' ),
			'search_items'               => __( 'Найти слайдер', 'project' ),
			'popular_items'              => __( 'Популярные слайдеры', 'project' ),
			'all_items'                  => __( 'Все слайдеры', 'project' ),
			'edit_item'                  => __( 'Изменить слайдер', 'project' ),
			'update_item'                => __( 'Обновить слайдер', 'project' ),
			'add_new_item'               => __( 'Добавить новый слайдер', 'project' ),
			'new_item_name'              => __( 'Новое имя слайдера', 'project' ),
			'separate_items_with_commas' => __( 'Введите слайдеры через запятую', 'project' ),
			'add_or_remove_items'        => __( 'Добавить или удалить слайдер', 'project' ),
			'choose_from_most_used'      => __( 'Выберите из популярных', 'project' ),
			'menu_name'                  => __( 'Слайдер', 'project' ),
		);

		register_taxonomy( 'slider', 'slide', array(
			'hierarchical' => false,
			'labels'       => $labels,
			'show_ui'      => true,
			'query_var'    => true,
			// 'rewrite'       => array( 'slug' => 'slider' ),
		) );
	}
}

if ( ! function_exists( 'sort_menu_slider' ) ) {
	function sort_menu_slider() {
		global $menu, $submenu;

		$last_submenu_item = array_pop( $submenu['edit.php?post_type=slide'] );
		array_unshift( $submenu['edit.php?post_type=slide'], $last_submenu_item );
	}
}

if ( ! function_exists( 'show_slider_shortcode' ) ) {
	function show_slider_shortcode( $actions, $tag ) {
		echo '<div class="form-field">';
		printf( '<input type="text" onclick="this.select()" value=\'[slider id="%d" columns="4"]\'>', $tag->term_id );
		echo '</div>';

		return $actions;
	}
}

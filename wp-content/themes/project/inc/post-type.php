<?php

add_action( 'init', 'register_type__slide' );
function register_type__slide() {
    $labels = array(
        'name'               => 'Слайды',
        'singular_name'      => 'Слайд',
        'add_new'            => 'Добавить слайд',
        'add_new_item'       => 'Добавить слайд',
        'edit_item'          => 'Редактировать слайд',
        'new_item'           => 'Новый слайд',
        'all_items'          => 'Все слайды',
        'view_item'          => 'Просмотр слайда на сайте',
        'search_items'       => 'Найти слайд',
        'not_found'          => 'Слайдов не найдено.',
        'not_found_in_trash' => 'В корзине нет слайдов.',
        'menu_name'          => 'Слайды',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable'  => null,
        'exclude_from_search' => null,
        'show_ui'             => null,
        'show_in_menu'        => null,
        'show_in_admin_bar'   => null,
        'show_in_nav_menus'   => null,
        // 'menu_icon'           => 'dashicons-cart',
        'menu_position'       => 15,
        'has_archive'         => true,
        'hierarchical'        => false,
        // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail'),
        // 'taxonomies' => array('post_tag'),
        'description'         => '',
    );

    register_post_type('post', $args);
}
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
        'menu_icon'           => 'dashicons-images-alt2',
        'menu_position'       => 15,
        'has_archive'         => true,
        'hierarchical'        => false,
        // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail'),
        // 'taxonomies' => array('post_tag'),
        'description'         => '',
    );

    register_post_type('slide', $args);
}

add_action( 'init', 'register_tax__slider' );
function register_tax__slider() {
    $labels = array(
        'name'                        => 'Слайдер',
        'singular_name'               => 'Слайдер',
        'search_items'                => 'Найти слайдер',
        'popular_items'               => 'Популярные слайдеры',
        'all_items'                   => 'Все слайдеры',
        'edit_item'                   => 'Изменить слайдер',
        'update_item'                 => 'Обновить слайдер',
        'add_new_item'                => 'Добавить новый слайдер',
        'new_item_name'               => 'Новое имя слайдера',
        'separate_items_with_commas'  => 'Введите слайдеры через запятую',
        'add_or_remove_items'         => 'Добавить или удалить слайдер',
        'choose_from_most_used'       => 'Выберите из популярных',
        'menu_name'                   => 'Слайдер',
    );

    register_taxonomy('slider', 'slide', array(
        'hierarchical'  => false,
        'labels'        => $labels,
        'show_ui'       => true,
        'query_var'     => true,
        // 'rewrite'       => array( 'slug' => 'slider' ),
    ));
}

add_action( 'admin_menu', 'change_menu_slider', 99 );
function change_menu_slider() {
    global $menu, $submenu;

    $last_submenu_item = array_pop($submenu['edit.php?post_type=slide']);
    array_unshift($submenu['edit.php?post_type=slide'], $last_submenu_item);
}

add_filter( 'slider_row_actions', 'slider_before_actions', 10, 2 );
function slider_before_actions($actions, $tag) {
    echo '<div class="form-field">';
    printf('<input type="text" onclick="this.select()" value=\'[slider id="%d" columns="4"]\'>', $tag->term_id);
    echo '</div>';

    return $actions;
}
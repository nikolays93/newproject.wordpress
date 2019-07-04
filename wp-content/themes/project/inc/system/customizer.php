<?php

add_filter( 'post_class', 'add_theme_post_class', 10, 3 );
if( !function_exists('add_theme_post_class') ) {
    function add_theme_post_class($classes, $class, $post_id) {
        if( 'product' !== get_post_type() ) {
            if( is_singular() ) {
                $columns = apply_filters( 'single_content_columns', 1 );
            }
            else {
                $columns = apply_filters( 'content_columns', 1 );
            }

            array_unshift($classes, function_exists('get_default_bs_columns') ?
                get_default_bs_columns( (int)$columns ) : 'columns-' . (int)$columns);
        }

        return $classes;
    }
}
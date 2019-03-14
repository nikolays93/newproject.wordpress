<?php

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

add_action('wp_head', 'template_viewport_html');
if( !function_exists('template_viewport_html') ) {
    function template_viewport_html() {
        if( TPL_RESPONSIVE ) {
            echo '
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">';
        }
        else {
            $max_width = TPL_VIEWPORT - ( TPL_PADDINGS * 2 );

            echo '
            <meta name="viewport" content="width='.TPL_VIEWPORT.'">
            <style type="text/css">
            .container {
                max-width: '.$max_width.'px !important;
                width: '.$max_width.'px !important;
            }
            </style>';
        }
    }
}

/**
 * Title template
 */
if( !function_exists('get_advanced_title') ) {
    function get_advanced_title( $post_id = null, $args = array() ) {
        $args = wp_parse_args( $args, array(
            'title_tag' => '',
            'title_class' => 'post-title',
            'clear' => false,
            'force' => false, // multiple | single
        ) );

        switch ( $args['force'] ) {
            case 'single':
                $is_singular = true;
                break;
            case 'multiple':
                $is_singular = false;
                break;
            default:
                $is_singular = is_singular();
                break;
        }

        if( ! $args['title_tag'] ) {
            $args['title_tag'] = $is_singular ? 'h1' : 'h2';
        }

        if( is_404() ) {
            return sprintf( '<%1$s class="%2$s error_not_found"> Ошибка #404: страница не найдена. </%1$s>',
                esc_html( $args['title_tag'] ),
                esc_attr( $args['title_class'] )
                );
        }

        /**
         * Get Title
         */
        if( ! $title = get_the_title( $post_id ) ) {
            // Title Not Found
            return false;
        }

        /**
         * Get Edit Post Icon
         */
        $edit_tpl = sprintf('<object><a href="%s" class="%s"></a></object>',
            get_edit_post_link( $post_id ),
            'dashicons dashicons-welcome-write-blog no-underline'
        );

        if( $args['clear'] ) {
            return $title . ' ' . $edit_tpl;
        }

        $result = array();

        if( ! $is_singular ) $result[] = sprintf('<a href="%s">', get_permalink( $post_id ));

        $title_html = sprintf('<%1$s class="%2$s">%3$s %4$s</%1$s>',
            esc_html( $args['title_tag'] ),
            esc_attr( $args['title_class'] ),
            $title,
            $edit_tpl
        );

        if( ! $is_singular ) {
            $title_html = sprintf('<a href="%s">%s</a>',
                get_permalink( $post_id ),
                $title_html
            );
        }

        return $title_html;
    }
}

if( !function_exists('the_advanced_title') ) {
    function the_advanced_title( $post_id = null, $args = array() ) {
        $args = wp_parse_args( $args, array(
            'before' => '',
            'after'  => '',
        ) );

        if( $title = get_advanced_title($post_id, $args) ) {
            echo $args['before'] . $title . $args['after'];
        }

        do_action( 'theme_after_title', $title );
    }
}

/**
 * Remove "Archive:" or "Category: " in archive page
 */
add_filter( 'get_the_archive_title', 'theme_archive_title_filter', 10, 1 );
if( !function_exists('theme_archive_title_filter') ) {
    function theme_archive_title_filter( $title ) {

        return preg_replace("/[\w]+: /ui", "", $title);
    }
}

/**
 * Insert thumbnail link
 *
 * @param html $thumbnail Thumbnail HTML code
 * @param int  $post_id   ИД записи превью которой добавляем ссылку
 */
if( !function_exists('add_thumbnail_link') ) {
    function add_thumbnail_link( $thumbnail, $post_id ) {
        if( ! $thumbnail || 0 == ($post_id = absint($post_id)) ) return '';

        $link = get_permalink( $post_id );
        $thumbnail_html = sprintf('<a class="media-left" href="%s">%s</a>',
            esc_url( $link ),
            $thumbnail);

        return $thumbnail_html;
    }
}

/**
 * Post content template
 *
 * @param  string  $affix  post_type
 * @param  boolean $return print or return
 * @return html
 */
if( !function_exists('get_tpl_content') ) {
    function get_tpl_content( $affix = false, $return = false, $container = 'row', $query = null ) {
        $templates = array();
        $slug = 'template-parts/content';

        if( ! $affix ) {
            $type = $affix = get_post_type();

            if($type == 'post')
                $affix = get_post_format();
        }

        if( $query && ! $query instanceof WP_Query ) {
          return false;
        }

        if( $return ) ob_start();

        if( $container ) {
            echo sprintf('<div class="%s">', esc_attr( $container ));
        }

        while ( $query ? $query->have_posts() : have_posts() ) {
            $query ? $query->the_post() : the_post();

            // need for search
            if( $affix === false ) {
                $affix = get_post_type();
            }

            if( 'product' !== $affix ) {
                if( is_single() ) {
                    $templates[] = "{$slug}-{$affix}-single.php";
                    $templates[] = "{$slug}-single.php";
                }
                elseif ( '' !== $affix ) {
                    $templates[] = "{$slug}-{$affix}.php";
                }

                $templates[] = "{$slug}.php";

                locate_template($templates, true, false);
            }
        }

        if( $container ) echo '</div>';

        wp_reset_postdata();

        if( $return ) return ob_get_clean();
    }
}

/**
 * Post content if is the search
 */
if( !function_exists('get_tpl_search_content') ) {
    function get_tpl_search_content( $return = false ) {
        ob_start();

        while ( have_posts() ) {
            the_post();

            if( 'product' === get_post_type() ) {
                wc_get_template_part( 'content', 'product' );
            }
        }

        $products = ob_get_clean();
        $content = get_tpl_content( false, true );

        if ( $products ) {
            $products = "<ul class='products row'>" . $products . "</ul>";
        }

        if( $return ) {
            return $products . $content;
        }

        echo $products . $content;
    }
}

/**
 * if is shidebar exists
 *
 * @return boolean / (string) sidebar name
 */
if( !function_exists('is_show_sidebar') ) {
    function is_show_sidebar() {
        $show_sidebar = false;

        if( TPL_DISABLE_SIDEBAR ) return false;

        if( ! is_singular() ) {
            $post_type = get_post_type();
            $enable_types = apply_filters( 'sidebar_archive_enable_on_type', array('post', 'page') );

            if( function_exists('is_woocommerce') ) {
                if( (is_woocommerce() || is_shop()) && is_active_sidebar('woocommerce') ) {
                    $show_sidebar = 'woocommerce';
                }
                if( is_cart() || is_checkout() || is_account_page() ) {
                    $show_sidebar = false;
                }
                elseif( is_active_sidebar('archive') && in_array($post_type, $enable_types) ) {
                    $show_sidebar = 'archive';
                }
            }
            else {
                if( is_active_sidebar('archive') && in_array($post_type, $enable_types) ) {
                    $show_sidebar = 'archive';
                }
            }
        }

        return apply_filters( 'is_show_sidebar', $show_sidebar );
    }
}


/*******************************************************************************
 * Default Template Filters and Actions
 */
add_action( 'dynamic_sidebar_before', 'aside_start', 10 );
if( !function_exists('aside_start') ) {
    function aside_start() {
        echo '</div>';
        echo '<div id="secondary" class="sidebar col-12 col-lg-3 order-lg-2">';
        echo '    <aside class="widget-area" role="complementary">';
    }
}

add_action( 'dynamic_sidebar_after',  'aside_end', 10 );
if( !function_exists('aside_end') ) {
    function aside_end() {
        echo '    </aside>';
    }
}

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

            $classes[] = function_exists('get_default_bs_columns') ?
                get_default_bs_columns( (int)$columns ) : array();
        }

        return $classes;
    }
}

/**
 * Русскоязычная дата
 */
add_filter('the_time', 'the_russian_date');
add_filter('get_the_time', 'the_russian_date');
add_filter('the_date', 'the_russian_date');
add_filter('get_the_date', 'the_russian_date');
add_filter('the_modified_time', 'the_russian_date');
add_filter('get_the_modified_date', 'the_russian_date');
add_filter('get_post_time', 'the_russian_date');
add_filter('get_comment_date', 'the_russian_date');

if( !function_exists('the_russian_date') ) {
    function the_russian_date( $tdate = '' ) {
        if ( substr_count($tdate , '---') > 0 ) {
            return str_replace('---', '', $tdate);
        }

        $treplace = array (
            "Январь" => "января",
            "Февраль" => "февраля",
            "Март" => "марта",
            "Апрель" => "апреля",
            "Май" => "мая",
            "Июнь" => "июня",
            "Июль" => "июля",
            "Август" => "августа",
            "Сентябрь" => "сентября",
            "Октябрь" => "октября",
            "Ноябрь" => "ноября",
            "Декабрь" => "декабря",

            "January" => "января",
            "February" => "февраля",
            "March" => "марта",
            "April" => "апреля",
            "May" => "мая",
            "June" => "июня",
            "July" => "июля",
            "August" => "августа",
            "September" => "сентября",
            "October" => "октября",
            "November" => "ноября",
            "December" => "декабря",

            "Sunday" => "воскресенье",
            "Monday" => "понедельник",
            "Tuesday" => "вторник",
            "Wednesday" => "среда",
            "Thursday" => "четверг",
            "Friday" => "пятница",
            "Saturday" => "суббота",

            "Sun" => "воскресенье",
            "Mon" => "понедельник",
            "Tue" => "вторник",
            "Wed" => "среда",
            "Thu" => "четверг",
            "Fri" => "пятница",
            "Sat" => "суббота",

            "th" => "",
            "st" => "",
            "nd" => "",
            "rd" => ""
            );
        return strtr($tdate, $treplace);
    }
}

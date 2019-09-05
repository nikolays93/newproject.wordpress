<?php

if ( ! defined( 'ABSPATH' ) ) { // You shall not pass
	exit;
}

/**
 * Title template
 * @todo morph to the_title filter
 */
if ( ! function_exists( 'get_advanced_title' ) ) {
	function get_advanced_title( $post_id = null, $args = array() ) {
		$args = wp_parse_args( $args, array(
			'title_tag'   => '',
			'title_class' => 'post-title',
			'clear'       => false,
			'force'       => false, // multiple | single
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

		if ( ! $args['title_tag'] ) {
			$args['title_tag'] = $is_singular ? 'h1' : 'h2';
		}

		if ( is_404() ) {
			return sprintf( '<%1$s class="%2$s error_not_found"> Ошибка #404: страница не найдена. </%1$s>',
				esc_html( $args['title_tag'] ),
				esc_attr( $args['title_class'] )
			);
		}

		/**
		 * Get Title
		 */
		if ( ! $title = get_the_title( $post_id ) ) {
			// Title Not Found
			return false;
		}

		/**
		 * Get Edit Post Icon
		 */
		$edit_tpl = sprintf( '<object><a href="%s" class="%s"></a></object>',
			get_edit_post_link( $post_id ),
			'dashicons dashicons-welcome-write-blog no-underline'
		);

		if ( $args['clear'] ) {
			return $title . ' ' . $edit_tpl;
		}

		$result = array();

		if ( ! $is_singular ) {
			$result[] = sprintf( '<a href="%s">', get_permalink( $post_id ) );
		}

		$title_html = sprintf( '<%1$s class="%2$s">%3$s %4$s</%1$s>',
			esc_html( $args['title_tag'] ),
			esc_attr( $args['title_class'] ),
			$title,
			$edit_tpl
		);

		if ( ! $is_singular ) {
			$title_html = sprintf( '<a href="%s">%s</a>',
				get_permalink( $post_id ),
				$title_html
			);
		}

		return $title_html;
	}
}

if ( ! function_exists( 'the_advanced_title' ) ) {
	function the_advanced_title( $post_id = null, $args = array() ) {
		$args = wp_parse_args( $args, array(
			'before' => '',
			'after'  => '',
		) );

		if ( $title = get_advanced_title( $post_id, $args ) ) {
			echo $args['before'] . $title . $args['after'];
		}

		do_action( 'theme_after_title', $title );
	}
}

if ( ! function_exists( 'theme_archive_title_filter' ) ) {
	/**
	 * Remove "Archive:" or "Category: " in archive page
	 */
	function theme_archive_title_filter( $title ) {
		return preg_replace( "/[\w]+: /ui", "", $title );
	}
}

/**
 * Insert thumbnail link
 *
 * @param html $thumbnail Thumbnail HTML code
 * @param int $post_id ИД записи превью которой добавляем ссылку
 */
if ( ! function_exists( 'add_thumbnail_link' ) ) {
	function add_thumbnail_link( $thumbnail, $post_id ) {
		if ( ! $thumbnail || 0 == ( $post_id = absint( $post_id ) ) ) {
			return '';
		}

		$link           = get_permalink( $post_id );
		$thumbnail_html = sprintf( '<a class="media-left" href="%s">%s</a>',
			esc_url( $link ),
			$thumbnail );

		return $thumbnail_html;
	}
}

/**
 * @start Layouts
 */
if ( ! function_exists( 'the_sidebar' ) ) {
	function the_sidebar() {
		$sidebar_class = apply_filters( 'site_sidebar_class', 'site-sidebar col-12 col-lg-3' );
		?>
        <div id="secondary" class="<?= $sidebar_class ?>">
            <aside class="widget-area" role="complementary">
				<?php get_sidebar(); ?>
            </aside>
        </div>
		<?php
	}
}

/**
 * Post content template
 *
 * @param string $affix post_type
 * @param boolean $return print or return
 *
 * @return html
 */
if ( ! function_exists( 'get_tpl_content' ) ) {
	function get_tpl_content( $affix = false, $return = false, $container = 'row', $query = null ) {
		$templates = array();
		$slug      = 'template-parts/content';

		if ( ! $affix ) {
			$type = $affix = get_post_type();

			if ( $type == 'post' ) {
				$affix = get_post_format();
			}
		}

		if ( $query && ! $query instanceof WP_Query ) {
			return false;
		}

		if ( $return ) {
			ob_start();
		}

		if ( $container ) {
			echo sprintf( '<div class="%s">', esc_attr( $container ) );
		}

		while ( $query ? $query->have_posts() : have_posts() ) {
			$query ? $query->the_post() : the_post();

			// need for search
			if ( $affix === false ) {
				$affix = get_post_type();
			}

			if ( 'product' !== $affix ) {
				if ( is_single() ) {
					$templates[] = "{$slug}-{$affix}-single.php";
					$templates[] = "{$slug}-single.php";
				} elseif ( '' !== $affix ) {
					$templates[] = "{$slug}-{$affix}.php";
				}

				$templates[] = "{$slug}.php";

				locate_template( $templates, true, false );
			}
		}

		if ( $container ) {
			echo '</div>';
		}

		wp_reset_postdata();

		if ( $return ) {
			return ob_get_clean();
		}
	}
}

/**
 * Post content if is the search
 */
if ( ! function_exists( 'get_tpl_search_content' ) ) {
	function get_tpl_search_content( $return = false ) {
		ob_start();

		while ( have_posts() ) {
			the_post();

			if ( 'product' === get_post_type() ) {
				wc_get_template_part( 'content', 'product' );
			}
		}

		$products = ob_get_clean();
		$content  = get_tpl_content( false, true );

		if ( $products ) {
			$products = "<ul class='products row'>" . $products . "</ul>";
		}

		if ( $return ) {
			return $products . $content;
		}

		echo $products . $content;
	}
}

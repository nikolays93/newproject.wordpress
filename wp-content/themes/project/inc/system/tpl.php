<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add edit icon after title if current user has permissions
 */
add_filter( 'the_title', function ( $title, $post_id ) {
	// Add Edit Post Icon
	if ( ! is_admin() && current_user_can( 'edit_pages' ) ) {
		$title .= sprintf( '<object><a href="%s" class="%s"></a></object>',
			get_edit_post_link( $post_id ),
			'dashicons dashicons-welcome-write-blog no-underline'
		);
	}

	return $title;
}, 10, 2 );

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
		$slug = 'template-parts/content';

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
			printf( '<div class="%s">', esc_attr( $container ) );
		}

		while ( $query ? $query->have_posts() : have_posts() ) {
			$query ? $query->the_post() : the_post();
			$templates = array();

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

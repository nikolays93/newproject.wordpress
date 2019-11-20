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

if( ! function_exists('the_template_content') ) {
	/**
	 * Post content template
	 *
	 * @param  null|WP_Query $query global wp query object.
	 * @param  string $suffix [description]
	 * @param  string $slug   [description]
	 * @return [type]         [description]
	 */
    function the_template_content( $query = null, $suffix = '', $slug = 'template-parts/content' ) {
    	if ( $query && ! $query instanceof WP_Query ) {
    		return new WP_Error( 'Incorrect parameters', sprintf(
    			'the tpl_content defines $query instance of WP_Query, but you %s defined.', gettype( $query ) ) );
		}

		$is_single = !empty( $query ) ? $query->is_single : is_singular();

    	if( '' === $suffix ) {
    		$post_type = ! empty( $query->query_vars['post_type'] ) ? $query->query_vars['post_type'] : get_post_type();
    		$suffix    = 'post' === $post_type ? get_post_format() : $post_type;
    	}

    	while ( $query ? $query->have_posts() : have_posts() ) {
			$query ? $query->the_post() : the_post();
			// Define each post suffix for search.
			// - Why not redefine $slug for product suffix?
			// - Products on serach already printed. (Woocommerce have a own loop.)
			if ( is_search() && '' === $suffix ) {
				$suffix = get_post_type();
				if( 'product' === $suffix ) {
					continue;
				}
			}

			$templates = array();
			if( '' !== $suffix ) {
				array_push($templates, $is_single ? "{$slug}-{$suffix}-single.php" : "{$slug}-{$suffix}.php");
			}
			if( $is_single ) {
				array_push($templates, "{$slug}-single.php");
			}
			array_push($templates, "{$slug}.php");

			locate_template( $templates, true, false );
		}

		wp_reset_postdata();

		return $suffix;
    }
}

/**
 * Post content on the search
 */
if ( ! function_exists( 'the_template_search_content' ) ) {
	function the_template_search_content() {
		ob_start();
		while ( have_posts() ) : the_post();
			if ( 'product' === get_post_type() ) {
				wc_get_template_part( 'content', 'product' );
			}
		endwhile;
		$products = ob_get_clean();

		ob_start();
		the_template_content();
		$content = ob_get_clean();

		if ( $products ) {
			$products = "<ul class='products row'>" . $products . "</ul>";
		}

		if ( $content ) {
			$content = "<div class='content row'>" . $content . "</div>";
		}

		echo $products . $content;
	}
}

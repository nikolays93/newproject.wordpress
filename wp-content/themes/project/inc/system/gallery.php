<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Gallery template
 */
add_filter( 'post_gallery', 'theme_gallery_callback', 10, 2 );
if ( ! function_exists( 'theme_gallery_callback' ) ) {
	function theme_gallery_callback( $output, $att ) {
		global $post;

		if ( isset( $att['orderby'] ) && ! $att['orderby'] = sanitize_sql_orderby( $att['orderby'] ) ) {
			unset( $att['orderby'] );
		}

		$att = shortcode_atts( array(
			'order'        => 'ASC',
			'orderby'      => 'menu_order ID',
			'gallery_id'   => $post->ID,
			'itemtag'      => 'div', // default: 'dl'
			'itemclass'    => 'row text-center',
			'icontag'      => 'div', // default: 'dt'
			'iconclass'    => '',
			'captiontag'   => 'div', // default: 'dd'
			'captionclass' => 'desc',
			'linkclass'    => 'zoom',
			'columns'      => 3,
			'size'         => 'thumbnail',
			'include'      => '',
			'exclude'      => '',
		), $att );

		if ( 'RAND' == $att['order'] ) {
			$att['orderby'] = 'none';
		}

		if ( $att['include'] ) {
			$include = preg_replace( '/[^0-9,]+/', '', $att['include'] );
			$include = array_filter( explode( ',', $include ), 'intval' );

			$attachments = get_posts( array(
				'include'        => $include,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $att['order'],
				'orderby'        => $att['orderby'],
			) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( ! $att['iconclass'] ) {
			$att['iconclass'] = function_exists( 'get_default_bs_columns' ) ?
				get_default_bs_columns( $att['columns'] ) : 'item';
		}

		$output   = array();
		$output[] = sprintf( '<section id="gallery-%d" class="gallery-wrapper">', $att['gallery_id'] );
		$output[] = "\t" . '<div class="preloader" style="display: none;"></div>';
		$output[] = "\t" . sprintf( '<%s class="%s">', esc_html( $att['itemtag'] ), esc_attr( $att['itemclass'] ) );

		foreach ( $attachments as $attachment ) {
			$url = wp_get_attachment_url( $attachment->ID );
			$img = wp_get_attachment_image_src( $attachment->ID, $att['size'] );

			$els = apply_filters( 'theme_gallery_elements', array(
				'wrap' => sprintf( '<%s class="%s">',
					esc_html( $att['icontag'] ),
					esc_attr( $att['iconclass'] ) ),

				'link' => sprintf( '<a href="%s" class="%s" rel="group-%d">',
					esc_url( $url ),
					esc_attr( $att['linkclass'] ),
					$att['gallery_id'] ),

				'pict' => sprintf( '<img src="%s" width="%s" height="%s" alt="" />',
					esc_url( $img[0] ),
					esc_attr( $img[1] ),
					esc_attr( $img[2] ) ),

				'desc' => sprintf( '<%1$s>%2$s</%1$s>', esc_html( $att['captiontag'] ),
					$attachment->post_excerpt )
			) );

			$output[] = "\t\t" . $els['wrap'];
			$output[] = "\t\t\t" . $els['link'];
			$output[] = "\t\t\t\t" . $els['pict'];
			$output[] = "\t\t\t\t" . $els['desc'];
			$output[] = "\t\t\t" . '</a>';
			$output[] = "\t\t" . sprintf( '</%s>', esc_html( $att['icontag'] ) );
		}

		$output[] = "\t" . sprintf( '</%s>', esc_html( $att['itemtag'] ) );
		$output[] = '</section><!-- .gallery-wrapper -->';

		return implode( "\r\n", $output );
	}
}

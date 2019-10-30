<?php

if ( ! function_exists( 'slider_shortcode' ) ) {
	function slider_shortcode( $atts = array(), $content = '' ) {
		$atts = shortcode_atts( array(
			'id' => 0,
		), $atts, 'slider' );

		if ( ! $atts['id'] = intval( $atts['id'] ) ) {
			return '';
		}

		$args = array(
			// Type & Status Parameters
			'post_type'      => 'slide',
			'post_status'    => 'publish',

			// Order & Orderby Parameters
			'order'          => 'ASC',
			'orderby'        => 'date',

			// Pagination Parameters
			'posts_per_page' => - 1,

			// Taxonomy Parameters
			'tax_query'      => array(
				'taxonomy'         => 'slider',
				'field'            => 'id',
				'terms'            => array( $atts['id'] ),
				'include_children' => false,
				'operator'         => 'IN',
			),
		);

		$query = new WP_Query( $args );

		$res = array();

		if ( $query->have_posts() ) {
			$res[] = sprintf( '<div class="slider-%d row justify-content-between">', $atts['id'] );
			while ( $query->have_posts() ) {
				$query->the_post();
				$res[] = '<div class="col">';
				$res[] = get_the_post_thumbnail( get_the_ID(), $size = 'post-thumbnail', $attr = '' );
				$res[] = '</div>';
			}
			$res[] = sprintf( '</div><!-- .slider-%d -->', $atts['id'] );
		}
		wp_reset_postdata();

		return implode( "\r\n", $res );
	}
}

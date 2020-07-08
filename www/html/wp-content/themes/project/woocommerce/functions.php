<?php
/*************************** Woocommerce Overrides ****************************/
/**
 * Unset default woocommerce styles override from ./inc/system/woocommerce.php
 *
 * @param array $enqueue_styles list of enqueues
 *
 * @return array
 */
function theme__dequeue_styles( $enqueue_styles ) {
	// unset( $enqueue_styles['woocommerce-general'] );     // Отключение общих стилей
	// unset( $enqueue_styles['woocommerce-layout'] );      // Отключение стилей шаблонов
	// unset( $enqueue_styles['woocommerce-smallscreen'] ); // Отключение оптимизации для маленьких экранов

	return $enqueue_styles;
}

/********************** Woocommerce Actions and Filters ***********************/

function change_wc_single_tabs( $tabs ) {
	global $post;

	if ( isset( $post->post_content ) && strlen( $post->post_content ) < 55 ) {
		unset( $tabs['description'] );
	} else {
		if ( isset( $tabs['description'] ) ) {
			$tabs['description']['title'] = __( 'Описание товара' );
		}
	}

	if ( isset( $tabs['reviews'] ) ) {
		unset( $tabs['reviews'] );
	}

	return $tabs;
}

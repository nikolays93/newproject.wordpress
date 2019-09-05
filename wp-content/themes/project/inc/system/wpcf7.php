<?php

const POST_ID_FIELD_NAME = '_current_post_id';

/**
 * @param WPCF7_ContactForm $WPCF7_ContactForm
 * @param $abort
 * @param $WPCF7_Submission
 */
function wpcf7_additional_info( $WPCF7_ContactForm, $abort, $WPCF7_Submission ) {

	$post_id = intval( $_REQUEST[ POST_ID_FIELD_NAME ] );
	$title   = get_the_title( $post_id );

	$protocol = isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
	@list( $ref_url, $ref_uri ) = explode( '?', $_SERVER['HTTP_REFERER'] );

	// redefine mail
	$mail         = $WPCF7_ContactForm->prop( 'mail' );
	$mail['body'] .= "\r\n\r\n_______________ Техническая информация _________________\r\n\r\n";
	if ( $title ) {
		$mail['body'] .= "Название страницы: " . $title . "\r\n";
	}
	if ( $ref_url ) {
		$mail['body'] .= "URL источника запроса: " . str_replace( $protocol . ':', '', $ref_url ) . "\r\n";
	}
	if ( $ref_uri ) {
		$get_params = array();
		parse_str( $ref_uri, $get_params );

		$mail['body'] .= "Параметры запроса: \r\n";
		foreach ( $get_params as $key => $value ) {
			$mail['body'] .= "$key: $value\r\n";
		}
	}

	$WPCF7_ContactForm->set_properties( array( 'mail' => $mail ) );
}

/**
 * @param array $fields
 *
 * @return array
 */
function wpcf7_post_id_field( $fields ) {
	$fields[ POST_ID_FIELD_NAME ] = get_the_ID();

	return $fields;
}

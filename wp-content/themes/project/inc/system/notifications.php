<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! defined( 'POST_ID_FIELD_NAME' ) ) {
	define( 'POST_ID_FIELD_NAME', '_current_post_id' );
}

if( ! defined( 'SMSRU_PATH_TO_API' ) ) {
	define( 'SMSRU_PATH_TO_API', __DIR__ . '/../class/sms.ru.php' ); // path to api class
}

if( ! defined( 'SMSRU_API_KEY' ) ) {
	define( 'SMSRU_API_KEY', '10CB4D41-A1C6-835A-A39E-08E01D1F219F' ); // example: 67EDB67C-1A0F-E887-6D3C-63491B64F2D8
}

if( ! defined( 'SMSRU_FROM' ) ) {
	define( 'SMSRU_FROM', '' );
}

if( ! defined( 'SMSRU_PHONE_NUMBER' ) ) {
	define( 'SMSRU_PHONE_NUMBER', '79128766683' ); // example: 79199169404
}

if( !function_exists('wpcf7_additional_info') ) {
	/**
	 * @param WPCF7_ContactForm $WPCF7_ContactForm
	 * @param $abort
	 * @param $WPCF7_Submission
	 */
	function wpcf7_additional_info( $WPCF7_ContactForm, $abort, $WPCF7_Submission ) {
		$posted_data = $WPCF7_Submission->get_posted_data();

		$post_id = intval( $posted_data[ POST_ID_FIELD_NAME ] );
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
			array_walk($get_params, function( $value, $key ) use ( &$mail ) {
				$mail['body'] .= "$key: $value\r\n";
			});
		}

		$WPCF7_ContactForm->set_properties( array( 'mail' => $mail ) );
	}
}

if( !function_exists('wpcf7_post_id_field') ) {
	/**
	 * @param array $fields
	 *
	 * @return array
	 */
    function wpcf7_post_id_field() {
    	$fields[ POST_ID_FIELD_NAME ] = get_the_ID();

    	return $fields;
    }
}

if( !function_exists('wpcf7_send_sms') ) {
	function wpcf7_send_sms( $WPCF7_ContactForm, $abort, $WPCF7_Submission ) {
		if( ! file_exists( SMSRU_PATH_TO_API ) ) {
			echo "Required file sms.ru not available.";
		}

		require_once SMSRU_PATH_TO_API;
		require_once __DIR__ . '../class/sms-provider.php';

		$posted_data = $WPCF7_Submission->get_posted_data();
		$name = sanitize_text_field( $posted_data['your-name'] );
		$phone = sanitize_text_field( $posted_data['your-phone'] );

		$smsru = new SMSRU( trim( SMSRU_API_KEY ) );
		$data = (new SMS_Provider())
			->set_from( SMSRU_FROM )
			->set_to( SMSRU_PHONE_NUMBER )
			->set_text( "Заказ звонка. $phone, $name" );

		/**
		 * Send sms results
		 *
		 * @var stdObject
		 * @note your may use $data->test = 1; $sms->status must be "OK"
		 */
		$sms = $smsru->send_one( apply_filters( 'theme_smsru_wpcf7_props', $data ) );
    }
}

if( !function_exists('woocommerce_new_order_send_sms') ) {
	function woocommerce_new_order_send_sms( $order_id ) {
		if( ! file_exists( SMSRU_PATH_TO_API ) ) {
			echo "Required file sms.ru not available.";
		}

		require_once SMSRU_PATH_TO_API;
		require_once __DIR__ . '/../class/sms-provider.php';

		$order = new WC_Order( $order_id );
		$name = $order->get_billing_first_name();
		$phone = $order->get_billing_phone();

		$smsru = new SMSRU( trim( SMSRU_API_KEY ) );
		$data = (new SMS_Provider())
			->set_from( SMSRU_FROM )
			->set_to( SMSRU_PHONE_NUMBER )
			->set_text( "Новый заказ #$order_id. $phone, $name" );

		$sms = $smsru->send_one( apply_filters( 'theme_smsru_order_props', $data ) );
    }
}

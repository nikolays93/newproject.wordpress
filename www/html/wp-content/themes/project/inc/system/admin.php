<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Set url to home on login header logotype
 */
add_filter( 'login_headerurl', 'home_url', 10, 0 );

/**
 * Change to own login header logotype
 */
add_action( 'login_header', 'login_header_logo_css' );
if ( ! function_exists( 'login_header_logo_css' ) ) {
	function login_header_logo_css() {
		/** @var Int $logo_id custom logotype attachment ID */
		if ( $logo_id = get_theme_mod( 'custom_logo' ) ) {
			@list( $src, $width, $height ) = wp_get_attachment_image_src( $logo_id, 'full' );
			?>
			<?php if ( $src && $width && $height ): ?>
				<style type="text/css">
					.login h1 a {
						background: url("<?= $src ?>") no-repeat;
						width: <?= $width ?>px;
						height: <?= $height ?>px;
						position: relative;
						left: 50%;
						transform: translateX(-50%);
					}
				</style>
			<?php endif; ?>
			<?php
		}
	}
}

/**
 * Link by developer in admin bar
 */
add_action( 'admin_bar_menu', 'customize_toolbar_link', 9999 );
if ( ! function_exists( 'customize_toolbar_link' ) ) {
	function customize_toolbar_link( $wp_admin_bar ) {
		if ( ! defined( 'DEVELOPER_NAME' ) || ! defined( 'DEVELOPER_LINK' ) ) {
			return false;
		}

		/**
		 * Developer menu link
		 */
		$wp_admin_bar->add_node( array(
			'id'    => 'developer',
			'title' => DEVELOPER_NAME,
			'href'  => DEVELOPER_LINK,
			'meta'  => array(
				'title' => __( 'Go to developer\'s website', 'project' ),
			),
		) );
	}
}

/**
 * Change "Thank you for creating with <a href="%s">WordPress</a>." message.
 */
add_filter( 'admin_footer_text', 'custom_admin_footer', 10, 1 );
if ( ! function_exists( 'custom_admin_footer' ) ) {
	function custom_admin_footer( $msg ) {
		if ( ! defined( 'DEVELOPER_NAME' ) ) {
			return $msg;
		}

		$dev_message = sprintf( '<span id="footer-thankyou">%s %s</span>.',
			__( 'Developed by', 'theme' ),
			DEVELOPER_NAME
		);

		$wp_message = sprintf( '<small><a href="wordpress.com">%s WordPress (%s)</a>. </small>',
			__( 'Based on', 'theme' ),
			get_bloginfo( 'version' ) . '-' . get_bloginfo( 'charset' )
		);

		return $dev_message . $wp_message;
	}
}

if ( ! function_exists( 'wp_authenticate_username_phone_password' ) ) {
	/**
	 * Authenticate a user, confirming the username or phonenumber and password are valid.
	 *
	 * @param WP_User|WP_Error|null $user WP_User or WP_Error object from a previous callback. Default null.
	 * @param string $username Username for authentication.
	 * @param string $password Password for authentication.
	 *
	 * @return WP_User|WP_Error WP_User on success, WP_Error on failure.
	 * @since 2.8.0
	 *
	 */
	function wp_authenticate_username_phone_password( $user, $username, $password ) {
		if ( $user instanceof WP_User ) {
			return $user;
		}

		// Check for empty fields
		if ( empty( $username ) || empty( $password ) ) {
			if ( is_wp_error( $user ) ) {
				return $user;
			}

			$error = new WP_Error();

			if ( empty( $username ) ) {
				$error->add( 'empty_username', __( '<strong>ERROR</strong>: The username field is empty.' ) );
			}

			if ( empty( $password ) ) {
				$error->add( 'empty_password', __( '<strong>ERROR</strong>: The password field is empty.' ) );
			}

			return $error;
		}

		$user_phone = preg_replace( '/[^0-9]/', '', $username );

		// Then username is phone
		if ( in_array( substr( $user_phone, 0, 1 ), [ 7, 8 ] ) ) {
			// Check if user exists in WordPress database
			$user = reset(
				get_users( [
					'meta_key'    => 'billing_phone',
					'meta_value'  => $user_phone,
					'number'      => 1,
					'count_total' => false
				] )
			);
		} else {
			$user = get_user_by( 'login', $username );
		}

		if ( ! $user ) {
			return new WP_Error(
				'invalid_username',
				__( '<strong>ERROR</strong>: Invalid username or phone number.' ) .
				' <a href="' . wp_lostpassword_url() . '">' .
				__( 'Lost your password?' ) .
				'</a>'
			);
		}

		/**
		 * Filters whether the given user can be authenticated with the provided $password.
		 *
		 * @param WP_User|WP_Error $user WP_User or WP_Error object if a previous
		 *                                   callback failed authentication.
		 * @param string $password Password to check against the user.
		 *
		 * @since 2.5.0
		 *
		 */
		$user = apply_filters( 'wp_authenticate_user', $user, $password );
		if ( is_wp_error( $user ) ) {
			return $user;
		}

		if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
			return new WP_Error(
				'incorrect_password',
				sprintf(
				/* translators: %s: user name */
					__( '<strong>ERROR</strong>: The password you entered for the login %s is incorrect.' ),
					'<strong>' . $username . '</strong>'
				) .
				' <a href="' . wp_lostpassword_url() . '">' .
				__( 'Lost your password?' ) .
				'</a>'
			);
		}

		return $user;
	}
}

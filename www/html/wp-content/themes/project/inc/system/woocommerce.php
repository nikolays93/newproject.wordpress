<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'theme__woocommerce_support' ) ) {
	/**
	 * Add Theme WooCommerce Support
	 */
	function theme__woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
}

if ( ! function_exists( 'theme__dequeue_styles' ) ) {
	/**
	 * Disable Default WooCommerce Styles
	 *
	 * @param array $enqueue_styles
	 *
	 * @return array
	 */
	function theme__dequeue_styles( $enqueue_styles ) {
		// unset( $enqueue_styles['woocommerce-general'] );     // Отключение общих стилей
		unset( $enqueue_styles['woocommerce-layout'] );      // Отключение стилей шаблонов
		unset( $enqueue_styles['woocommerce-smallscreen'] ); // Отключение оптимизации для маленьких экранов

		return $enqueue_styles;
	}
}

if ( ! function_exists( 'widget__woocommerce' ) ) {
	/**
	 * SideBar For WooCommerce pages
	 */
	function widget__woocommerce() {
		register_sidebar( array(
			'name'          => __( 'Витрины магазина', 'project' ),
			'id'            => 'woocommerce',
			'description'   => __( 'Показываются на витринах магазина WooCommerce', 'project' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}

if ( ! function_exists( 'placeholder__change_img_src' ) ) {
	/**
	 * Change Default Placeholder
	 *
	 * @param string $src
	 *
	 * @return string
	 */
	function placeholder__change_img_src( $src ) {
		$ph = 'img/placeholder.png';
		if ( is_readable( THEME . $ph ) ) {
			$src = TPL . $ph;
		}

		return $src;
	}
}

if ( ! function_exists( 'price__wc20_variation_format' ) ) {
	/**
	 * @param WC_Product_Variable $product
	 */
	function wc20_get_variation_price( $product ) {
		return array(
			'min' => $product->get_variation_price( 'min', true ),
			'max' => $product->get_variation_price( 'max', true )
		);
	}

	/**
	 * @param WC_Product_Variable $product
	 */
	function wc20_get_variation_regular_price( $product ) {
		return array(
			'min' => $product->get_variation_regular_price( 'min', true ),
			'max' => $product->get_variation_regular_price( 'max', true )
		);
	}

	/**
	 * @param string $price woocommerce 2.0 variation price formatter
	 * @param WC_Product_Variable $product
	 *
	 * @return string
	 */
	function price__wc20_variation_format( $price, $product ) {

		$_price = wc20_get_variation_price( $product );
		if ( $_price['min'] ) {
			$price = wc_price( $_price['min'] );

			if ( $_price['min'] !== $_price['max'] ) {
				$price = 'от ' . $price;
			}
		}

		$_regular_price = wc20_get_variation_regular_price( $product );
		if ( $_regular_price['min'] ) {
			$sale_price = wc_price( $_regular_price['min'] );

			if ( $_regular_price['min'] !== $_regular_price['max'] ) {
				$sale_price = 'от ' . $sale_price;
			}

			if ( $price !== $sale_price ) {
				$price = sprintf( '<del>%s</del> <ins>%s</ins>', $sale_price, $price );
			}
		}

		return $price;
	}
}

if ( ! function_exists( 'price__currency_symbol' ) ) {
	function price__currency_symbol( $currency_symbol, $currency ) {
		if ( 'RUB' == $currency ) {
			$currency_symbol = '<i class="fa fa-rub">руб.</i>';
		}

		return $currency_symbol;
	}
}

if ( ! function_exists( 'checkout__validate_billing_phone' ) ) {
	/**
	 * @param array $fields
	 * @param WP_Error $errors
	 */
	function checkout__validate_billing_phone( $fields, $errors ) {
		$pattern = get_validate_phone_pattern();
		if ( ! empty( $fields['billing_phone'] ) && ! preg_match( "/$pattern/", $fields['billing_phone'] ) ) {
			$errors->add( 'phone_formatter_err', __( '<strong>Номер телефона</strong> указан не верно.', 'project' ) );
		}
	}
}

/**
 * #bilig_phone ES validation
 * @TODO Not working now
 */
add_action( 'wp_footer', function () {
	// we need it only on our checkout page
	if ( ! is_checkout() ) {
		return;
	}

	$pattern = get_validate_phone_pattern();

	?>
    <script>
        jQuery(function ($) {
            $('body').on('blur change', '#billing_phone', function () {
                $(this).closest('.form-row').addClass(
                    /<?= $pattern ?>/.test( $(this).val() ) ? 'woocommerce-validated' : 'woocommerce-invalid'
                );
            });
        });
    </script>
	<?php
} );

if ( ! function_exists( 'checkout__default_address_fields' ) ) {
	function checkout__default_address_fields( $fields ) {
		// Set required
		$fields['last_name']['required'] = false;
		$fields['address_1']['required'] = false;

		// Unset fields
		unset( $fields['address_2'], $fields['postcode'] );

		// Add bootstrap class for all fields
		//foreach ( $fields as &$field ) {
		//	if ( is_array( $field['input_class'] ) && ! in_array( 'form-control', $field['input_class'] ) ) {
		//		array_push( $field['input_class'], 'form-control' );
		//	}
		//}

		return $fields;
	}
}

if ( ! function_exists( 'checkout__set_fields_priority' ) ) {
	function checkout__set_fields_priority( $fields ) {
		$priority = array(
			'address_1' => 70,
			'city'      => 60,
			'state'     => 50,
			'email'     => 24,
			'phone'     => 22,
		);

		array_map( function ( $label ) use ( &$fields, $priority ) {

			foreach ( $priority as $k => $v ) {
				if ( isset( $fields[ $label ]["{$label}_{$k}"] ) ) {
					$fields[ $label ]["{$label}_{$k}"]['priority'] = $v;
				}
			}

		}, array( 'billing', 'shipping' ) );

		return $fields;
	}
}

if ( ! function_exists( 'checkout__add_fields_bootstrap_class' ) ) {
	function checkout__add_fields_bootstrap_class( $fields ) {
		// For all sections
		foreach ( array( 'billing', 'shipping', 'account', 'order' ) as $field_key ) {
			if ( ! isset( $fields[ $field_key ] ) || ! is_array( $fields[ $field_key ] ) ) {
				continue;
			}

			// Add bootstrap class for all fields
			foreach ( $fields[ $field_key ] as $key => &$field ) {
				if( empty( $field['input_class'] ) ) {
					$field['input_class'] = array();
				}

				if ( is_array( $field['input_class'] ) && ! in_array( 'form-control', $field['input_class'] ) ) {
					array_push( $field['input_class'], 'form-control' );
				}
			}
		}

		return $fields;
	}
}

if ( ! function_exists( 'account__menu_items' ) ) {
	function account__menu_items( $items ) {
		// $items = array(
		//     'orders' => __( 'Orders', 'woocommerce' ),
		//     'edit-address' => __( 'Addresses', 'woocommerce' ),
		//     'payment-methods' => __( 'Payment methods', 'woocommerce' ),
		//     'edit-account' => __( 'Account details', 'woocommerce' ),
		//     'customer-logout' => __( 'Logout', 'woocommerce' ),
		// );

		unset( $items['dashboard'], $items['downloads'] );

		return $items;
	}
}

if ( ! function_exists( 'account__required_inputs' ) ) {
	function account__required_inputs( $required_fields ) {
		$required_fields = array(
			// 'account_first_name' => __( 'First name', 'woocommerce' ),
			// 'account_last_name'  => __( 'Last name', 'woocommerce' ),
			'account_email' => __( 'Email address', 'woocommerce' ),
		);

		return $required_fields;
	}
}

if ( ! function_exists( 'change_wc_order_statuses' ) ) {
	/**
	 * @param array $order_statuses
	 *  'wc-pending'    => _x( 'Pending payment', 'Order status', 'woocommerce' )
	 *  'wc-processing' => _x( 'Processing', 'Order status', 'woocommerce' )
	 *  'wc-on-hold'    => _x( 'On hold', 'Order status', 'woocommerce' )
	 *  'wc-completed'  => _x( 'Completed', 'Order status', 'woocommerce' )
	 *  'wc-cancelled'  => _x( 'Cancelled', 'Order status', 'woocommerce' )
	 *  'wc-refunded'   => _x( 'Refunded', 'Order status', 'woocommerce' )
	 *  'wc-failed'     => _x( 'Failed', 'Order status', 'woocommerce' )
	 *
	 * @return array
	 */
	function change_wc_order_statuses( $order_statuses ) {
		if ( isset( $order_statuses['wc-completed'] ) ) {
			// Выполнен to Оплачен
			$order_statuses['wc-completed'] = _x( 'Оплачен', 'Order status', 'woocommerce' );
		}

		return $order_statuses;
	}
}

if ( ! function_exists( 'logout_after_registration_redirect' ) ) {
	/**
	 * Do Not Log in after registration user.
	 */
	function logout_after_registration_redirect() {
		wp_logout();

		return home_url( '/my-account/?register_success=1&action=login' );
	}
}

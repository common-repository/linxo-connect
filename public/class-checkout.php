<?php
class Linxo_Woo_Checkout {

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts_styles() {

		if ( is_checkout() ) {
			$checkout_assets = include( LINXO_WOO_PLUGIN_PATH . 'public/assets/build/checkout-page.asset.php' );
			wp_enqueue_style( 'linxo_woo_checkout_page', LINXO_WOO_PLUGIN_URL . 'public/assets/build/checkout-page.css', array(), $checkout_assets['version'], 'all' );
			wp_enqueue_script( 'linxo_woo_checkout_page', LINXO_WOO_PLUGIN_URL . 'public/assets/build/checkout-page.js', $checkout_assets['dependencies'], $checkout_assets['version'], true );
		}
	}

    /**
	 * Add the payment gateway to the list of available payment methods
	 */
	public function blocks_support() {

		if( ! class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
			return;
		}

		require plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-blocks-support.php';

		add_action(
			'woocommerce_blocks_payment_method_type_registration',
			function( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
				$payment_method_registry->register(new Linxo_Woo_Blocks_Support);
			}
		);
	}

	/**
	 * Get the woocommerce notices
	 */
	public function check_wc_notice() {

		$linxo_notices	= array();
		$error_notices	= wc_get_notices('error');

		foreach ( $error_notices as $notice_array ) {
			$id = $notice_array['data']['id'] ?? '';
			if ( $id === 'linxo-woo' ) {
				$linxo_notices[] = $notice_array;
			}
		}

		if ( !empty( $linxo_notices ) ) {
			wc_clear_notices();
		}

		wp_send_json_success( $linxo_notices );
	}

}
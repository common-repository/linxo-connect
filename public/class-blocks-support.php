<?php
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

defined( 'ABSPATH' ) || exit;

final class Linxo_Woo_Blocks_Support extends AbstractPaymentMethodType {

	protected $name = 'linxo_woo';
    /**
	 * Initializes the payment method type.
	 */
	public function initialize() {}

    /**
	 * Returns if this payment method should be active. If false, the scripts will not be enqueued.
	 *
	 * @return boolean
	 */
	public function is_active() {
        return true;
	}

    /**
	 * Returns an array of scripts/handles to be registered for this payment method.
	 *
	 * @return array
	 */
	public function get_payment_method_script_handles() {

        $checkout_blocks_assets = include( LINXO_WOO_PLUGIN_PATH . 'public/assets/build/checkout-blocks.asset.php' );
        wp_register_script( LINXO_WOO_TEXT_DOMAIN . '_checkout_blocks', LINXO_WOO_PLUGIN_URL . 'public/assets/build/checkout-blocks.js', $checkout_blocks_assets['dependencies'], $checkout_blocks_assets['version'], true );
		wp_localize_script( LINXO_WOO_TEXT_DOMAIN . '_checkout_blocks', 'linxo_data', array(
			'ajax_url'	=> admin_url( 'admin-ajax.php' ),
			'nonce'		=> wp_create_nonce( 'linxo_woo_nonce' ),
			'action'	=> isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action']) : '',
		));

		return [
            LINXO_WOO_TEXT_DOMAIN . '_checkout_blocks',
        ];
	}

	/**
	 * Returns an array of localized strings for this payment method.
	 */
	public function get_payment_method_data() {

		$linxo_woo_payment_methods = apply_filters( 'linxo_woo_payment_methods', array() );

		$methods = array();

		foreach ( $linxo_woo_payment_methods as $payment_method ) {

			$method_data = array(
				'name'	        => $payment_method->id,
				'label'	        => $payment_method->title,
				'icon'	        => $payment_method->icon,
                'description'   => $payment_method->description,
			);

			$methods[] = $method_data;
		}

		return [
			'methods' => $methods
		];
	}
}
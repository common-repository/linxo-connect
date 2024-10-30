<?php
class Linxo_Woo_WC_Payment_Gateway {

    /**
     * Init the payment gateways
     */
    public function payment_gateway_init() {

		if ( ! class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
			return;
		}

		require_once LINXO_WOO_PLUGIN_PATH . 'admin/wc-payment-methods/class-wc-gateway-linxo-woo.php';

		Linxo_Woo_WC_Gateway::get_instance('Linxo_Woo_WC_Gateway')->init_hooks();

		add_filter( 'woocommerce_payment_gateways', array( $this, 'add_gateways' ) );
    }

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts_styles( $hook_suffix ) {

		if ( 'woocommerce_page_wc-settings' === $hook_suffix ) {
			$payment_methods_assets = include( LINXO_WOO_PLUGIN_PATH . 'public/assets/build/admin-payment-methods.asset.php' );
			wp_enqueue_style( 'linxo_woo_payment_methods', LINXO_WOO_PLUGIN_URL . 'public/assets/build/admin-payment-methods.css', array(), $payment_methods_assets['version'], 'all' );
			wp_enqueue_script( 'linxo_woo_payment_methods', LINXO_WOO_PLUGIN_URL . 'public/assets/build/admin-payment-methods.js', $payment_methods_assets['dependencies'], $payment_methods_assets['version'], true );
		}
	}

    /**
	 * Add custom payment gateways
	 */
	public function add_gateways( $methods ) {

		$linxo_methods		= array();

		$linxo_methods[] = new Linxo_Woo_WC_Gateway;

		add_filter( 'linxo_woo_payment_methods', function( $methods ) use ( $linxo_methods ){
			return $linxo_methods;
		});

        return array_merge( $methods, $linxo_methods );
	}

    /**
	 * Show a notice if the woocommerce plugin not exist or not activated
	 */
	public function woocommerce_missing_notice() {

		echo '<div class="error"><p><strong>' . esc_html__( "Linxo Woo requires WooCommerce to be installed and active.", 'linxo-woo' ) . '</strong></p></div>';
	}

}
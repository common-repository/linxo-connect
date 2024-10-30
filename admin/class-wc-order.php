<?php
class Linxo_Woo_WC_Order {

    /**
     * Add meta box payment info
     */
    public function add_meta_box_payment_info( $post ) {

        $current_screen = get_current_screen();
		$screen_id      = $current_screen->id;

        add_meta_box(
            'linxo_woo_payment_info',
            esc_html__( 'Linxo Connect', 'linxo-woo' ),
            array( $this, 'render_meta_box_payment_info' ),
            $screen_id,
            'normal',
            'high'
        );
    }

    /**
     * Render meta box payment info
     */
    public function render_meta_box_payment_info( $post ) {

        $admin_single_order_assets = include( LINXO_WOO_PLUGIN_PATH . 'public/assets/build/admin-single-order.asset.php' );
		wp_enqueue_style( 'linxo_woo_admin_single_order', LINXO_WOO_PLUGIN_URL . 'public/assets/build/admin-single-order.css', array(), $admin_single_order_assets['version'], 'all' );
		wp_enqueue_script( 'linxo_woo_admin_single_order', LINXO_WOO_PLUGIN_URL . 'public/assets/build/admin-single-order.js', $admin_single_order_assets['dependencies'], $admin_single_order_assets['version'], true );

        $order = wc_get_order( \Automattic\WooCommerce\Utilities\OrderUtil::get_post_or_order_id( $post ) );

        switch ( $order->get_payment_method() ) {
            case 'linxo_woo':
                $method = new Linxo_Woo_WC_Gateway();
                $method->show_details_in_admin($order);
            break;
        }

    }

}
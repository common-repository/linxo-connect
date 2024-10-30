<?php
class Linxo_Woo_Put_Order_Closed {

    private $token;
    private $url;
    private $linxo_order_id;

    public function set_linxo_order_id( $linxo_order_id ) {
        $this->linxo_order_id = $linxo_order_id;
    }

    /**
     * Init class
     */
    public function init_class() {

        $linxo_woo_get_oauth2_bearer = new Linxo_Woo_Get_OAuth2_Bearer();
        $this->token    = $linxo_woo_get_oauth2_bearer->get_token();
        $this->url      = linxo_woo_api_base_url('running/orders');
    }

    /**
     * Cancel an order
     */
    public function cancel_order() {

        $this->init_class();

        $headers = array(
            'X-FWD-Request-ID'  => wp_generate_uuid4(),
            'Authorization'     => 'Bearer ' . $this->token,
            'Content-Type'      => 'application/json',
        );

        $body = array(
            'order_status' => 'CLOSED',
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ) );
        linxo_woo_add_log( $message );

        $response = wp_remote_request( $this->url . '/' . $this->linxo_order_id, array(
            'method'    => 'PUT',
            'headers'   => $headers,
            'body'      => wp_json_encode($body)
        ));

        if ( is_wp_error( $response ) ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": WP_Error: %s", wp_json_encode($response) );
            linxo_woo_add_log( $message, 'error' );
            return false;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        $response_body = wp_remote_retrieve_body( $response );

        if ( $response_code != 204 ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s", $response_code );
        linxo_woo_add_log( $message );

        return true;
    }

}
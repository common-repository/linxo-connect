<?php
class Linxo_Woo_Get_List_Aliases {

    private $user_reference;
    private $token;
    private $url;

    public function set_user_reference( $user_reference ) {
        $this->user_reference = $user_reference;
    }

    /**
     * Init class
     */
    public function init_class() {
        
        $linxo_woo_get_oauth2_bearer = new Linxo_Woo_Get_OAuth2_Bearer();
        $this->token    = $linxo_woo_get_oauth2_bearer->get_token();
        $this->url      = linxo_woo_api_base_url('alias');
    }

    /**
     * Get list of aliases
     */
    public function get_list() {

        $this->init_class();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Authorization'    => 'Bearer ' . $this->token,
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ) );
        linxo_woo_add_log( $message );

        $response = wp_remote_get( $this->url . '?page=1&limit=100&user_reference=' . $this->user_reference, array(
            'headers'   => $headers,
        ));

        if ( is_wp_error( $response ) ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": WP_Error: %s", wp_json_encode($response) );
            linxo_woo_add_log( $message, 'error' );
            return false;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        $response_body = wp_remote_retrieve_body( $response );

        if ( $response_code != 200 ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }
        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
        linxo_woo_add_log( $message );

        return json_decode( $response_body );
    }

}
<?php
class Linxo_Woo_Delete_Alias {

    private $alias_id;
    private $token;
    private $url;

    public function set_alias_id( $alias_id ) {
        $this->alias_id = $alias_id;
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
     * Delete an alias
     */
    public function delete_alias() {

        $this->init_class();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Authorization'    => 'Bearer ' . $this->token,
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ) );
        linxo_woo_add_log( $message );

        $response = wp_remote_request( $this->url . '/' . $this->alias_id, array(
            'method'    => 'DELETE',
            'headers'   => $headers,
        ));

        if ( is_wp_error( $response ) ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": WP_Error: %s", wp_json_encode($response) );
            linxo_woo_add_log( $message, 'error' );
            return false;
        }

        $response_code      = wp_remote_retrieve_response_code( $response );
        $response_body      = wp_remote_retrieve_body( $response );

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
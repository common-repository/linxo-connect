<?php
class Linxo_Woo_Webhook_Url {

    private $token_transient;
    private $client_id;
    private $client_secret;
    private $grant_type;
    private $token_url;
    private $url;
    private $unsubscribe_url;

    public function set_client_id( $client_id ) {
        $this->client_id = $client_id;
    }

    public function set_client_secret( $client_secret ) {
        $this->client_secret = $client_secret;
    }

    /**
     * Init class
     */
    public function init_class() {

        $this->token_transient  = 'linxo_woo_oauth2_bearer_token';
        $this->grant_type       = 'client_credentials';
        $this->token_url        = linxo_woo_api_base_url('token');
        $this->url              = linxo_woo_api_base_url('subscribe');
        $this->unsubscribe_url  = linxo_woo_api_base_url('unsubscribe');
    }

    /**
     * Register webhook url
     */
    public function register_webhook() {

        $this->init_class();
        $token = $this->get_token();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Content-Type'     => 'application/json',
            'Authorization'    => 'Bearer ' . $token,
        );

        $body = array(
            'callback_url'   => add_query_arg( array('action' => 'notification'), trailingslashit(site_url('wc-api/' . 'Linxo_Woo_WC_Gateway'))),
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s, REQUEST_BODY: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ), wp_json_encode($body) );
        linxo_woo_add_log( $message );

        $response = wp_remote_post( $this->url, array(
            'headers'   => $headers,
            'body'      => wp_json_encode( $body ),
        ));

        if ( is_wp_error( $response ) ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": WP_Error: %s", wp_json_encode($response) );
            linxo_woo_add_log( $message, 'error' );
            return false;
        }

        $response_code = wp_remote_retrieve_response_code( $response );

        if ( $response_code != 201 ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s.", $response_code );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s.", $response_code );
        linxo_woo_add_log( $message );

        return true;
    }

    /**
     * Unregister webhook url
     */
    public function unregister_webhook() {

        $this->init_class();
        $token = $this->get_token();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Content-Type'     => 'application/json',
            'Authorization'    => 'Bearer ' . $token,
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ) );
        linxo_woo_add_log( $message );

        $response = wp_remote_post( $this->unsubscribe_url, array(
            'headers'   => $headers,
        ));

        if ( is_wp_error( $response ) ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": WP_Error: %s", wp_json_encode($response) );
            linxo_woo_add_log( $message, 'error' );
            return false;
        }

        $response_code = wp_remote_retrieve_response_code( $response );

        if ( $response_code != 204 ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s.", $response_code );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s.", $response_code );
        linxo_woo_add_log( $message );

        return true;
    }

    /**
     * Get the token
     */
    private function get_token() {

        $token = get_transient( $this->token_transient );

        if ( !$token ) {

            $response = $this->request_token();

            if ( $response ) {
                
                $token      = $response->access_token;
                $expires_in = $response->expires_in;
                $expires_in = $expires_in - ( $expires_in * 0.1 );

                set_transient( $this->token_transient, $token, $expires_in );
            }
        }
        
        return $token;
    }

    /**
     * Request the token
     */
    private function request_token() {

        $headers    = array(
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . base64_encode( $this->client_id . ':' . $this->client_secret ),
        );
        $body       = array(
            'grant_type' => $this->grant_type,
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s, REQUEST_BODY: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ), wp_json_encode($body) );
        linxo_woo_add_log( $message );

        $response = wp_remote_post( $this->token_url, array(
            'headers'   => $headers,
            'body'      => $body,
        ));

        if ( is_wp_error( $response ) ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": WP_Error: %s", wp_json_encode($response) );
            linxo_woo_add_log( $message, 'error' );
            return false;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        $response_body = wp_remote_retrieve_body( $response );

        if ( $response_code != 200 ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY: %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
        linxo_woo_add_log( $message );

        return json_decode( $response_body );
    }

}
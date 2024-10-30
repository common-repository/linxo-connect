<?php
class Linxo_Woo_Get_OAuth2_Bearer {

    private $token_transient;
    private $client_id;
    private $client_secret;
    private $grant_type;
    private $url;

    public function __construct() {
        
        $this->token_transient  = 'linxo_woo_oauth2_bearer_token';
        $this->client_id        = linxo_woo_get_client_id();
        $this->client_secret    = linxo_woo_get_client_secret();
        $this->grant_type       = 'client_credentials';
        $this->url              = linxo_woo_api_base_url('token');

    }
    
    /**
     * get_transient_key
     */
    public function get_transient_key() {
        $is_account_demo_mode = linxo_woo_get_option( 'account_demo_mode' );
        $prefix               = $is_account_demo_mode === '1' ? 'sandbox_' : 'production_';
        
        return $prefix . $this->token_transient;
    }

    /**
     * Get the token
     */
    public function get_token($refresh = []) {
        $token_transient_key = $this->get_transient_key();
        $token               = get_transient( $token_transient_key );

        if ( !$token && empty($refresh)) {

            $response = $this->request_token();

            if ( $response ) {
                
                $token      = $response->access_token;
                $expires_in = $response->expires_in;
                $expires_in = $expires_in - ( $expires_in * 0.1 );

                set_transient( $token_transient_key, $token, $expires_in );
            }
        }

        if(!empty($refresh)){
            $token      = $refresh->access_token;
            $expires_in = $refresh->expires_in;
            $expires_in = $expires_in - ( $expires_in * 0.1 );

            set_transient( $token_transient_key, $token, $expires_in );
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

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': REQUEST_HEADER: %1$s, REQUEST_BODY: %2$s', linxo_woo_mask_bearer_token( wp_json_encode($headers) ), wp_json_encode($body) );
        linxo_woo_add_log( $message );

        $response = wp_remote_post( $this->url, array(
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

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY: %2$s', $response_code, $response_body );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, $response_body );
        linxo_woo_add_log( $message );

        return json_decode( $response_body );
    }

}
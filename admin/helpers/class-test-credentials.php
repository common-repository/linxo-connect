<?php
class Linxo_Woo_Test_Credentials {

    private $client_id;
    private $client_secret;
    private $grant_type;
    private $url;

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
        
        $this->grant_type   = 'client_credentials';
        $this->url          = linxo_woo_api_base_url('token');
    }

    /**
     * Test Credentials
     */
    public function test_credentials() {

        $this->init_class();

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
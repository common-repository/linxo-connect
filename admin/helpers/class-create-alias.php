<?php
class Linxo_Woo_Create_Alias {

    private $user_reference;
    private $label;
    private $bic;
    private $schema;
    private $iban;
    private $token;
    private $url;

    public function set_user_reference( $user_reference ) {
        $this->user_reference = $user_reference;
    }

    public function set_label( $label ) {
        $this->label = $label;
    }

    public function set_bic( $bic ) {
        $this->bic = $bic;
    }

    public function set_schema( $schema ) {
        $this->schema = $schema;
    }

    public function set_iban( $iban ) {
        $this->iban = $iban;
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
     * Create an alias
     */
    public function add_alias() {

        $this->init_class();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Content-Type'     => 'application/json',
            'Authorization'    => 'Bearer ' . $this->token,
        );
        $body = array(
            'user_reference'    => $this->user_reference,
            'label'             => $this->label,
            'account'           => array(
                'schema'    => $this->schema,
                'iban'      => $this->iban,
            )
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': REQUEST_HEADER: %1$s, REQUEST_BODY: %2$s', linxo_woo_mask_bearer_token( wp_json_encode($headers) ), linxo_woo_mask_iban_values( wp_json_encode($body) ) );
        linxo_woo_add_log( $message );

        $response = wp_remote_post( $this->url, array(
            'headers'   => $headers,
            'body'      => wp_json_encode( $body ),
        ));

        if ( is_wp_error( $response ) ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': WP_Error: %s', wp_json_encode($response) );
            linxo_woo_add_log( $message, 'error' );
            return false;
        }

        $response_code = wp_remote_retrieve_response_code( $response );
        $response_body = wp_remote_retrieve_body( $response );

        if ( $response_code != 201 ) {

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
        linxo_woo_add_log( $message );

        return json_decode( $response_body );
    }

}
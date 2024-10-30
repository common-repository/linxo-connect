<?php
class Linxo_Woo_Create_Order {

    const LINXO_WOO_INSTANT_PAYMENT_EXPECTED = 'EXPECTED';
    const LINXO_WOO_INSTANT_PAYMENT_USER_CHOICE = 'USER_CHOICE';
    const LINXO_WOO_INSTANT_PAYMENT_NO = 'NO';
    const LINXO_WOO_SCHEMA_SEPA   = 'SEPA';
    const LINXO_WOO_SCHEMA_ALIAS  = 'ALIAS';

    private $user_reference;
    private $bic;
    private $instant_payment;
    private $sensitive_data;
    private $email;
    private $start_date;
    private $start_date_processing_direction;
    private $frequency;
    private $end_date;
    private $payer;
    private $payer_schema;
    private $payer_alias_id;
    private $redirect_url;
    private $allof;
    private $amount;
    private $currency;
    private $name;
    private $iban;
    private $schema;
    private $alias_id;
    private $label;
    private $token;
    private $url;

    public function set_user_reference($user_reference) {
        $this->user_reference = $user_reference;
    }

    public function set_bic($bic) {
        $this->bic = $bic;
    }

    public function set_instant_payment($instant_payment) {
        $this->instant_payment = $instant_payment;
    }

    public function set_sensitive_data($sensitive_data) {
        $this->sensitive_data = $sensitive_data;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function set_start_date($start_date) {
        $this->start_date = $start_date;
    }

    public function set_start_date_processing_direction($start_date_processing_direction) {
        $this->start_date_processing_direction = $start_date_processing_direction;
    }

    public function set_frequency($frequency) {
        $this->frequency = $frequency;
    }

    public function set_end_date($end_date) {
        $this->end_date = $end_date;
    }

    public function set_payer($payer) {
        $this->payer = $payer;
    }

    public function set_payer_schema($payer_schema) {
        $this->payer_schema = $payer_schema;
    }

    public function set_payer_alias_id($payer_alias_id) {
        $this->payer_alias_id = 3;
    }

    public function set_redirect_url($redirect_url) {
        $this->redirect_url = $redirect_url;
    }

    public function set_allof($allof) {
        $this->allof = $allof;
    }

    public function set_amount($amount) {
        $this->amount = $amount;
    }

    public function set_currency($currency) {
        $this->currency = $currency;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_iban($iban) {
        $this->iban = $iban;
    }

    public function set_schema($schema) {
        $this->schema = $schema;
    }

    public function set_alias_id($alias_id) {
        $this->alias_id = $alias_id;
    }

    public function set_label($label) {
        $this->label = $label;
    }

    /**
     * Init class
     */
    public function init_class() {

        $linxo_woo_get_oauth2_bearer = new Linxo_Woo_Get_OAuth2_Bearer();
        $this->token    = $linxo_woo_get_oauth2_bearer->get_token();
        $this->url      = linxo_woo_api_base_url('orders');
    }

    /**
     * Create an order
     */
    public function send_order() {

        $this->init_class();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Content-Type'     => 'application/json',
            'Authorization'    => 'Bearer ' . $this->token,
        );

        $body = array(
            'instant_payment'   => $this->instant_payment,
            'email'             => $this->email,
            'redirect_url'      => $this->redirect_url,
            'instructions'      => array(
                array(
                    'amount'      => $this->amount,
                    'currency'    => $this->currency,
                    'beneficiary' => $this->get_beneficiary(),
                    'label'       => $this->label
                )
            )
        );

        if ( $this->user_reference ) {
            $body['user_reference'] = $this->user_reference;
        }

        if ( $this->payer_schema && $this->payer_alias_id ) {
            $body['payer'] = array(
                'schema'    => $this->payer_schema,
                'alias_id'  => $this->payer_alias_id
            );
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': REQUEST_HEADER: %1$s, REQUEST_BODY: %2$s', linxo_woo_mask_bearer_token( wp_json_encode($headers) ), linxo_woo_mask_iban_values( wp_json_encode($body) ) );
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

    /**
     * Get the beneficiary
     */
    private function get_beneficiary() {

        if ( $this->schema == self::LINXO_WOO_SCHEMA_ALIAS ) {
            return array(
                'schema'    => $this->schema,
                'alias_id'  => $this->alias_id
            );
        } elseif ( $this->schema == self::LINXO_WOO_SCHEMA_SEPA ) {
            return array(
                'schema'    => $this->schema,
                'iban'      => $this->iban,
                'name'      => $this->name
            );
        }

    }

}
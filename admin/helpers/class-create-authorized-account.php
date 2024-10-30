<?php
class Linxo_Woo_Create_Authorized_Account {

    const LINXO_WOO_TYPE_COMPANY  = 'COMPANY';
    const LINXO_WOO_TYPE_PERSON   = 'NATURAL_PERSON';

    private $company_iban;
    private $company_name;
    private $company_company_name;
    private $company_national_identification;
    private $company_country;
    private $person_firstname;
    private $person_surname;
    private $person_birth_date;
    private $person_birth_city;
    private $person_birth_country;
    private $person_iban;
    private $person_name;
    private $type;
    private $token;
    private $url;

    public function set_company_iban( $company_iban ) {
        $company_iban = str_replace(' ', '', $company_iban);
        $this->company_iban = $company_iban;
    }

    public function set_company_name( $company_name ) {
        $this->company_name = $company_name;
    }

    public function set_company_company_name( $company_company_name ) {
        $this->company_company_name = $company_company_name;
    }

    public function set_company_national_identification( $company_national_identification ) {
        $this->company_national_identification = $company_national_identification;
    }

    public function set_company_country( $company_country ) {
        $this->company_country = $company_country;
    }

    public function set_person_firstname( $person_firstname ) {
        $this->person_firstname = $person_firstname;
    }

    public function set_person_surname( $person_surname ) {
        $this->person_surname = $person_surname;
    }

    public function set_person_birth_date( $person_birth_date ) {
        $person_birth_date = gmdate('Y/m/d', strtotime($person_birth_date));
        $this->person_birth_date = $person_birth_date;
    }

    public function set_person_birth_city( $person_birth_city ) {
        $this->person_birth_city = $person_birth_city;
    }

    public function set_person_birth_country( $person_birth_country ) {
        $this->person_birth_country = $person_birth_country;
    }

    public function set_person_iban( $person_iban ) {
        $person_iban = str_replace(' ', '', $person_iban);
        $this->person_iban = $person_iban;
    }
    
    public function set_person_name( $person_name ) {
        $this->person_name = $person_name;
    }

    public function set_type( $type ) {
        $this->type = $type;
    }

    /**
     * Init class
     */
    public function init_class() {

        $linxo_woo_get_oauth2_bearer = new Linxo_Woo_Get_OAuth2_Bearer();
        $this->token    = $linxo_woo_get_oauth2_bearer->get_token();
        $this->url      = linxo_woo_api_base_url('authorized_accounts');
    }

    /**
     * Add an account
     */
    public function add_account() {

        $this->init_class();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Content-Type'     => 'application/json',
            'Authorization'    => 'Bearer ' . $this->token,
        );
        $body = array(
            'identification'    => $this->get_identification(),
            'entity'            => $this->get_entity(),
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s, REQUEST_BODY: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ), linxo_woo_mask_iban_values( wp_json_encode($body) ) );
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

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s, RESPONSE_BODY %s", $response_code, linxo_woo_mask_iban_values($response_body) );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s, RESPONSE_BODY %s", $response_code, linxo_woo_mask_iban_values($response_body) );
        linxo_woo_add_log( $message );

        return json_decode( $response_body );
    }

    /**
     * Get the identification
     */
    private function get_identification() {

        $identification = array();

        if ( self::LINXO_WOO_TYPE_COMPANY === $this->type ) {

            $identification['schema']   = 'SEPA';
            $identification['iban']     = $this->company_iban;
            $identification['name']     = $this->company_name;

        } elseif ( self::LINXO_WOO_TYPE_PERSON === $this->type ) {

            $identification['schema']   = 'SEPA';
            $identification['iban']     = $this->person_iban;
            $identification['name']     = $this->person_name;
        }

        return $identification;
    }

    /**
     * Get the entity
     */
    private function get_entity() {

        $entity = array();

        if ( self::LINXO_WOO_TYPE_COMPANY === $this->type ) {

            $entity['type']                     = self::LINXO_WOO_TYPE_COMPANY;
            $entity['company_name']             = $this->company_company_name;
            $entity['national_identification']  = $this->company_national_identification;
            $entity['country']                  = $this->company_country;

        } elseif ( self::LINXO_WOO_TYPE_PERSON === $this->type ) {

            $entity['type']             = self::LINXO_WOO_TYPE_PERSON;
            $entity['firstname']        = $this->person_firstname;
            $entity['surname']          = $this->person_surname;
            $entity['birth_date']       = $this->person_birth_date;
            $entity['birth_city']       = $this->person_birth_city;
            $entity['birth_country']    = $this->person_birth_country;
        }

        return $entity;
    }

}
<?php
class Linxo_Woo_Get_Specific_Order {

    private $token;
    private $url;
    private $order_id;
    private $get_alias_class;
    private $get_list_providers_class;

    public function set_order_id( $order_id ) {
        $this->order_id = $order_id;
    }

    /**
     * Init class
     */
    public function init_class() {

        $linxo_woo_get_oauth2_bearer = new Linxo_Woo_Get_OAuth2_Bearer();
        $this->token    = $linxo_woo_get_oauth2_bearer->get_token();
        $this->url      = linxo_woo_api_base_url('reporting/orders');

        $this->get_alias_class = new Linxo_Woo_Get_Alias();
        $this->get_list_providers_class = new Linxo_Woo_Get_List_Providers();
    }

    /**
     * Get a specific order
     */
    public function get_order() {

        $this->init_class();

        $headers = array(
            'X-FWD-Request-ID' => wp_generate_uuid4(),
            'Authorization'    => 'Bearer ' . $this->token,
        );

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": REQUEST_HEADER: %s", linxo_woo_mask_bearer_token( wp_json_encode($headers) ) );
        linxo_woo_add_log( $message );

        $response = wp_remote_get( $this->url . '/' . $this->order_id, array(
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

            $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ": RESPONSE_CODE: %s, RESPONSE_BODY %s", $response_code, linxo_woo_mask_iban_values($response_body) );
            linxo_woo_add_log( $message, 'error' );

            return false;
        }

        $message = sprintf( __CLASS__ . ':' . __FUNCTION__ . ': RESPONSE_CODE: %1$s, RESPONSE_BODY %2$s', $response_code, linxo_woo_mask_iban_values($response_body) );
        linxo_woo_add_log( $message );

        return json_decode( $response_body );
    }

    /**
     * Format a specific order
     */
    public function admin_format( $response ) {

        $amount_text        = '';
        $first_instruction  = $response->instructions[0] ?? false;
        if ( $first_instruction ) {
            $amount_text        = ($first_instruction->amount ?? '') . ' ' . ($first_instruction->currency ?? '');
        }

        $payer_schema   = $response->payer->schema ?? '';
        $get_providers  = true;

        if ( $payer_schema ==  'ALIAS' ) {

            $this->get_alias_class->set_id( $response->payer->alias_id ?? '' );
            $alias_response = $this->get_alias_class->get_alias();

            if ( $alias_response ) {

                $response_payer = json_decode( wp_json_encode( $alias_response->account ), true );

            } else {
                
                $get_providers  = false;
                $response_payer = array();
            }

        } else {

            $response_payer = json_decode( wp_json_encode( $response->payer ), true );
        }

        if ( $get_providers ) {
            $this->get_list_providers_class->set_payer( [$response_payer] );
            $providers_response = $this->get_list_providers_class->get_providers();
            $providers          = $providers_response->result ?? false;
    
            if (!$providers) {
                $response_payer['provider'] = array(
                    'name'  => '-',
                    'logo'  => '',
                );
            } else {
                $first_provider = $providers[0] ?? new stdClass();
                $provider_obj   = $first_provider->providers[0] ?? new stdClass();
                $response_payer['provider'] = array(
                    'name'  => $provider_obj->name ?? '',
                    'logo'  => $provider_obj->logo_url ?? '',
                );
            }
        }

        $payments_data = array();
        if( is_array( $response->instructions ) ) {
            foreach ( $response->instructions as $instruction ) {
                if ( isset($instruction->payments) && is_array( $instruction->payments ) ) {
                    foreach ( $instruction->payments as $payment ) {
        
                        list($execution_date, $nanos)   = explode('.', $payment->execution_date ?? '');
                        $execution_date                 = wp_date( 'd/m/y H:i:s', strtotime( $execution_date ) );
        
                        $payments_data[] = array(
                            'amount_text'       => ($payment->amount ?? '') . ' ' . ($payment->currency ?? ''),
                            'status'            => $payment->status ?? '',
                            'execution_date'    => linxo_woo_format_nano_date( $payment->execution_date ?? '' ),
                            'label'             => $instruction->label ?? '',
                        );
                    }
                }
            }
        }

        $formated_data = array(
            'order'     => array(
                'id'                => $response->id ?? '',
                'user_reference'    => $response->user_reference ?? '',
                'status'            => $response->order_status ?? '',
                'type'              => $response->instant_payment ?? '',
                'type_text'         => $response->selected_capability === 'SINGLE_PAYMENT' ? esc_html__('Standard', 'linxo-woo') : esc_html__('Instant', 'linxo-woo'),
                'email'             => $response->email ?? '',
                'creation_date'     => linxo_woo_format_nano_date( $response->creation_date ?? '' ),
                'amount_text'       => $amount_text,
            ),
            'payer'     => $response_payer,
            'payments'  => $payments_data,
        );

        return $formated_data;
    }

}
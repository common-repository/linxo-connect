<?php
class Linxo_Woo_WC_Order_Data {

    const LINXO_WOO_STATUS_NEW                = 'NEW';
    const LINXO_WOO_STATUS_AUTHORIZED         = 'AUTHORIZED';
    const LINXO_WOO_STATUS_CLOSED             = 'CLOSED';
    const LINXO_WOO_STATUS_REJECTED           = 'REJECTED';
    const LINXO_WOO_STATUS_FAILED             = 'FAILED';
    const LINXO_WOO_STATUS_EXPIRED            = 'EXPIRED';

    const LINXO_WOO_PAYMENT_STATUS_SUBMITTED  = 'SUBMITTED';
    const LINXO_WOO_PAYMENT_STATUS_EXECUTED   = 'EXECUTED';
    const LINXO_WOO_PAYMENT_LINXO_WOO_STATUS_REJECTED   = 'REJECTED';
    const LINXO_WOO_PAYMENT_STATUS_CANCELLED  = 'CANCELLED';

    private $order_data;

    public function set_order_data( $order_data ) {
        $this->order_data = $order_data;
    }

    public function get_order_data() {
        return $this->order_data;
    }

    /**
     * Get the order state
     */
    public function get_order_status() {

        $status                                 = false;
        $linxo_order_status                     = $this->order_data->order_status ?? '';
        $linxo_order_payment_status             = $this->order_data->instructions[0]->payments[0]->status ?? '';
        $linxo_order_payment_status_raw_reason  = $this->order_data->instructions[0]->payments[0]->payment_status_raw_reason ?? '';

        switch ($linxo_order_status) {

            case self::LINXO_WOO_STATUS_AUTHORIZED:
                if ( self::LINXO_WOO_PAYMENT_STATUS_SUBMITTED === $linxo_order_payment_status ) {
                    $status = linxo_woo_get_option( 'statuses_authorized_status' );
                    $this->order_data->validate_order = true;
                }
            break;

            case self::LINXO_WOO_STATUS_CLOSED:
                if ( self::LINXO_WOO_PAYMENT_STATUS_EXECUTED === $linxo_order_payment_status ) {
                    $status = linxo_woo_get_option( 'statuses_captured_status' );
                    $this->order_data->validate_order = true;
                } elseif ( self::LINXO_WOO_PAYMENT_LINXO_WOO_STATUS_REJECTED === $linxo_order_payment_status ) {
                    if ( 'DS02' === $linxo_order_payment_status_raw_reason ){
                        $status = linxo_woo_get_option( 'statuses_cancelled_status' );
                    } else {
                        $status = linxo_woo_get_option( 'statuses_error_status' );
                    }
                }
            break;

            case self::LINXO_WOO_STATUS_REJECTED:
                if ( self::LINXO_WOO_PAYMENT_LINXO_WOO_STATUS_REJECTED === $linxo_order_payment_status ) {
                    if ( 'DS02' === $linxo_order_payment_status_raw_reason ){
                        $status = linxo_woo_get_option( 'statuses_cancelled_status' );
                    } else {
                        $status = linxo_woo_get_option( 'statuses_error_status' );
                    }
                } elseif( self::LINXO_WOO_PAYMENT_STATUS_CANCELLED === $linxo_order_payment_status) {
                    $status = linxo_woo_get_option( 'statuses_cancelled_status' );
                }
            break;

            case self::LINXO_WOO_STATUS_FAILED:
                $status = linxo_woo_get_option( 'statuses_error_status' );
            break;

            case self::LINXO_WOO_STATUS_EXPIRED:
                $status = linxo_woo_get_option( 'statuses_cancelled_status' );
            break;
        }

        return $status;
    }

}
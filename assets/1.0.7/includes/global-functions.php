<?php
/**
 * The global functions for this plugin
 * 
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 /**
  * Get the default value of an option
  */
function linxo_woo_get_default_option( $value_id ) {

    $default_values_array = array(
        'account_demo_mode'                     => '1',
        'account_client_id'                     => '',
        'account_client_secret'                 => '',
        'account_client_id_demo'                => '',
        'account_client_secret_demo'            => '',
        'iban_active_account'                   => '',
        'advanced_enable_logs'                  => '0',
        'advanced_payment_type'                 => 'classic',
        'advanced_manual_entry_page_display'    => '0',
        'advanced_alias_storage_enabled'        => '0',
        'statuses_authorized_status'            => 'wc-on-hold',
        'statuses_captured_status'              => 'wc-processing',
        'statuses_cancelled_status'             => 'wc-cancelled',
        'statuses_error_status'                 => 'wc-failed',
    );

    return $default_values_array[$value_id] ?? '';
}

/**
 * Get a specific option
 */
function linxo_woo_get_option( $option_id ) {
    return get_option( 'linxo_woo_' . $option_id, linxo_woo_get_default_option( $option_id ) );
}

/**
 * Get the client id
 */
function linxo_woo_get_client_id() {

    if ( linxo_woo_get_mode() === 'demo' ) {
        return linxo_woo_get_option('account_client_id_demo');
    }

    return linxo_woo_get_option('account_client_id');
}

/**
 * Get the client secret
 */
function linxo_woo_get_client_secret() {

    if ( linxo_woo_get_mode() === 'demo' ) {
        return linxo_woo_get_option('account_client_secret_demo');
    }

    return linxo_woo_get_option('account_client_secret');
}

/**
 * Sanitize text
 */
function linxo_woo_sanitize_text( $data, $key ) {

    $id = 'linxo_woo_' . $key;
    
    if ( isset( $data[$id] ) ) {

        return sanitize_text_field( $data[$id] );
    }

    return linxo_woo_get_default_option($key);
}

/**
 * Sanitize SVG markup for front-end display.
 *
 * @param  string $svg SVG markup to sanitize.
 * @return string 	  Sanitized markup.
 */
function linxo_woo_sanitize_svg ($path = '' )
{
    $output = wp_remote_get($path);
    $svg = $output['body'];
    $svg_args = linxo_woo_svg_args();

    return wp_kses($svg, $svg_args);
}

/**
 * Get the mode
 */
function linxo_woo_get_mode() {

    $mode = linxo_woo_get_option('account_demo_mode');

    if ( $mode === '1' ) {
        return 'demo';
    }

    return 'prod';
}

/**
 * Get all log files
 */
function linxo_woo_get_log_files() {

    $log_dir    = linxo_woo_get_log_dir();
    $files      = @scandir( $log_dir );
    $result     = array();

    if ( !empty( $files ) ) {

        rsort( $files );

        foreach ( $files as $file ) {

            if ( strstr( $file, 'linxo-woo' ) ) {
                array_push( $result, $file );
            }
        }
    }
    
    return $result;
}

/**
 * Get the path of the log files
 */
function linxo_woo_get_log_dir() {

    $upload_dir = wp_upload_dir();
    $log_dir    = $upload_dir['basedir'] . '/wc-logs/';

    return $log_dir;
}

/**
 * Add a message to the log file
 */
function linxo_woo_add_log( $message, $level = 'debug' ) {

	$advanced_enable_logs = linxo_woo_get_option( 'advanced_enable_logs' );

    if ( $advanced_enable_logs === '1' ) {

        if ( function_exists('wc_get_logger') ) {

            $logger = wc_get_logger();
            switch ($level) {
                case 'debug':
                    $logger->debug( $message, array('source' => LINXO_WOO_TEXT_DOMAIN) );
                break;
                case 'error':
                    $logger->error( $message, array('source' => LINXO_WOO_TEXT_DOMAIN) );
                break;
            }
        }
    }

}

/**
 * linxo_woo_mask_iban_values
 *
 * @param  mixed $string
 * @return void
 */
function linxo_woo_mask_iban_values( $string ) {
    $string = !is_string($string) ? wp_json_encode($string) : $string;

    $regex = '/("iban"\s*:\s*")([a-zA-Z0-9]+)"/';

    $masked_string = preg_replace_callback( $regex, function($matches) {
        if( !isset($matches[2]) ) return $matches[0];
        if( strlen($matches[2]) < 8 ) return $matches[0];
        $masked_iban = substr($matches[2], 0, 4) . str_repeat('*', strlen($matches[2]) - 8) . substr($matches[2], -4);
        return $matches[1] . $masked_iban . '"';
    }, $string);

    return $masked_string;
}

/**
 * linxo_woo_mask_bearer_token
 *
 * @param  mixed $string
 * @return void
 */
function linxo_woo_mask_bearer_token( $string ) {
    $string = !is_string($string) ? wp_json_encode($string) : $string;

    $regex = '/("Authorization"\s*:\s*"Bearer\s+)([^\"]+)"/';

    $masked_string = preg_replace_callback( $regex, function($matches) {
        if( !isset($matches[2]) ) return $matches[0];
        if( strlen($matches[2]) < 24 ) return $matches[0];
        $masked_token = substr($matches[2], 0, 10) . '****' . substr($matches[2], -10);
        return $matches[1] . $masked_token . '"';
    }, $string);

    return $masked_string;
}

/**
 * Get the base url of the API
 */
function linxo_woo_api_base_url( $route = '' ) {

    if ( $route === 'token' ) {
        return 'https://pay.oxlin.io/token';
    }

    return 'https://pay.oxlin.io/v1/' . $route;
}

/**
 * Get countries
 */
function linxo_woo_get_countries() {

    $countries = array();

    if ( class_exists('WC_Countries') ) {
        $wc_countries = new WC_Countries();
        $countries = $wc_countries->get_countries();
    }

    return $countries;
}

/**
 * Set the first alias as the default one
 */
function linxo_woo_first_alias_as_default() {

    $get_list_aliases_class = new Linxo_Woo_Get_List_Aliases();
    $get_list_aliases_class->set_user_reference( sprintf('M-%s', md5(linxo_woo_get_client_id())));
    $aliases_response   = $get_list_aliases_class->get_list();
    $aliases_list       = $aliases_response->aliases ?? array();

    if ( !empty( $aliases_list ) ) {
        return $aliases_list[0]->id ?? '';
    }

    return '';
}

/**
 * Get the default alias
 */
function linxo_woo_get_default_alias() {

    $default_alias = linxo_woo_get_option('iban_active_account');

    if ( empty( $default_alias ) ) {
        $default_alias = linxo_woo_first_alias_as_default();
    }

    return $default_alias;
}

/**
 * Get the default value from an array of statuses
 */
function linxo_woo_get_statuses( $status_key ) {

	$statuses_array = function_exists('wc_get_order_statuses') ? wc_get_order_statuses() : array();
    $default_value  = linxo_woo_get_default_option($status_key);

    if ( isset( $statuses_array[$default_value] ) ) {
        $statuses_array[$default_value] = $statuses_array[$default_value] . ' ' . esc_html__( '(default)', 'linxo-woo' );
    }
    
    return $statuses_array;
}

/**
 * Format the date with nanoseconds
 */
function linxo_woo_format_nano_date( $date ) {

    $date_array = explode( '.', $date );

    if ( empty( $date_array ) || count( $date_array ) < 2 ) {
        return '';
    }

    $only_date                  = strtotime( $date_array[0] );

    if ( empty($only_date) ) {
        return '';
    }

    $formated_date = wp_date( 'd/m/y H:i:s', $only_date );

    return $formated_date;
}

/**
 * Get SVG args for escaping
 */
function linxo_woo_svg_args() {

    $svg_args = array(
        'svg'   => array(
            'class'           => true,
            'aria-hidden'     => true,
            'aria-labelledby' => true,
            'role'            => true,
            'xmlns'           => true,
            'xmlns:xlink'     => true,
            'width'           => true,
            'height'          => true,
            'fill'            => true,
            'viewbox'         => true // <= Must be lower case!
        ),
        'g'     => array(
            'fill' => true
        ),
        'title' => array(
            'title' => true
        ),
        'path'  => array( 
            'd'    => true, 
            'fill' => true  
        ),
        'ellipse' => array( 'cx' => true, 'cy' => true, 'rx' => true, 'ry' => true ),
        'rect'    => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true ),
        'circle'  => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true ),
        'defs'    => array( 'class' => true ),
        'pattern' => array( 'width' => true, 'height' => true, 'patternunits' => true, 'patterncontentunits' => true, 'id' => true ),
        'use'     => array( 'xlink:href' => true, 'transform' => true ),
        'image'   => array( 'xlink:href' => true, 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'id' => true )
    );

    return $svg_args;
}

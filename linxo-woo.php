<?php

/**
 *
 * @link              https://www.linxo.com/
 * @since             1.0.1
 * @package           Linxo_Woo
 *
 * @wordpress-plugin
 * Plugin Name:       Linxo Connect
 * Plugin URI:        https://linxoconnect.com/produits/payments/
 * Description:       Offer a new, user-friendly payment option for your customers, suitable for any amount. Make transfers easier and more secure to boost your conversion rates.
 * Version:           1.0.8
 * Author:            Linxo
 * Author URI:        https://linxoconnect.com/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       linxo-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Check if your are in local or production environment
 */
$is_local = isset($_SERVER['REMOTE_ADDR']) && ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1');

$version  = get_file_data( __FILE__, array( 'Version' => 'Version' ), false )['Version'];

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LINXO_WOO_VERSION', $version );

/**
 * You can use this const for check if you are in local environment
 */
define( 'LINXO_WOO_DEV_MOD', $is_local );

/**
 * Plugin Name text domain for internationalization.
 */
define( 'LINXO_WOO_TEXT_DOMAIN', 'linxo-woo' );

/**
 * Plugin Name Path for plugin includes.
 */
define( 'LINXO_WOO_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin Name URL for plugin sources (css, js, images etc...).
 */
define( 'LINXO_WOO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-linxo-woo-activator.php
 */
register_activation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-linxo-woo-activator.php';
	Linxo_Woo_Activator::activate();
} );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-linxo-woo-deactivator.php
 */
register_deactivation_hook( __FILE__, function(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-linxo-woo-deactivator.php';
	Linxo_Woo_Deactivator::deactivate();
} );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-linxo-woo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function linxo_woo_run() {

	$plugin = new Linxo_Woo();
	$plugin->run();

}
linxo_woo_run();

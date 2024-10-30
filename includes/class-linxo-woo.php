<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.linxo.com/
 * @since      1.0.0
 *
 * @package    Linxo_Woo
 * @subpackage Linxo_Woo/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Linxo_Woo
 * @subpackage Linxo_Woo/includes
 * @author     Linxo <contact@linxo.com>
 */
class Linxo_Woo {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Linxo_Woo_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Linxo_Woo_Loader. Orchestrates the hooks of the plugin.
	 * - Linxo_Woo_i18n. Defines internationalization functionality.
	 * - Linxo_Woo_Admin. Defines all hooks for the admin area.
	 * - Linxo_Woo_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for loading composer dependencies.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'includes/vendor/autoload.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'includes/class-linxo-woo-loader.php';

		/**
		 * This file is loaded only on local environement for test or debug.
		 */
		if( $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1' ){
			require_once LINXO_WOO_PLUGIN_PATH. 'includes/dev-toolkits.php';
		}
		
		/**
		 * The global functions for this plugin
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'includes/global-functions.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'includes/class-linxo-woo-i18n.php';

		/**
		 * The class responsible of settings.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/class-settings.php';

		/**
		 * Handle the custom WC payment gateway
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/class-wc-payment-gateway.php';

		
		/**
		 * The class responsible of WC order.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/class-wc-order.php';
		
		/**
		 * The class responsible of cron job.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/class-cron-job.php';

		/**
		 * The class responsible of the OAuth2 bearer token.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-oauth2-bearer.php';

		/**
		 * The class responsible of testing credentials.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-test-credentials.php';

		/**
		 * The class responsible of creating authorized account.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-create-authorized-account.php';

		/**
		 * The class responsible of getting authorized account.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-specific-authorized-account.php';

		/**
		 * The class responsible of deleting authorized account.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-delete-specific-authorized-account.php';

		/**
		 * The class responsible of creating order.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-create-order.php';

		/**
		 * The class responsible of creating alias.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-create-alias.php';

		/**
		 * The class responsible of getting alias.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-alias.php';

		/**
		 * The class responsible of deleting alias.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-delete-alias.php';

		/**
		 * The class responsible of getting list of aliases.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-list-aliases.php';

		/**
		 * The class responsible of getting list of providers.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-list-providers.php';

        /**
         * The class responsible of getting list of authorize account.
         */
        require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-list-authorized-account.php';

		/**
		 * The class responsible of getting order realtime.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-order-realtime.php';

		/**
		 * The class responsible of order data.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-wc-order-data.php';

		/**
		 * The class responsible of webhook url.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-webhook-url.php';

		/**
		 * The class responsible of getting specific order.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-get-specific-order.php';

		/**
		 * The class responsible of canceling order.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'admin/helpers/class-put-order-closed.php';

		/**
		 * The class responsible of the checkout page.
		 */
		require_once LINXO_WOO_PLUGIN_PATH . 'public/class-checkout.php';

		$this->loader = new Linxo_Woo_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Linxo_Woo_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$linxo_woo_settings = new Linxo_Woo_Settings();
		$this->loader->add_action( 'admin_enqueue_scripts', $linxo_woo_settings, 'enqueue_scripts_styles' );
		$this->loader->add_action( 'admin_menu', $linxo_woo_settings, 'add_settings_menu' );
		$this->loader->add_action( 'init', $linxo_woo_settings, 'save_settings' );
		$this->loader->add_action( 'wp_ajax_linxo_woo_get_log_file_content', $linxo_woo_settings, 'get_log_file_content' );
		$this->loader->add_action( 'admin_init', $linxo_woo_settings, 'maybe_redirect_to_onboarding', 11 );

		$linxo_woo_wc_payment_gateway = new Linxo_Woo_WC_Payment_Gateway();
		$this->loader->add_action( 'plugins_loaded', $linxo_woo_wc_payment_gateway, 'payment_gateway_init' );
		$this->loader->add_action( 'admin_enqueue_scripts', $linxo_woo_wc_payment_gateway, 'enqueue_scripts_styles' );

		$linxo_woo_wc_order = new Linxo_Woo_WC_Order();
		$this->loader->add_action( 'add_meta_boxes_shop_order', $linxo_woo_wc_order, 'add_meta_box_payment_info' );
		$this->loader->add_action( 'add_meta_boxes_woocommerce_page_wc-orders', $linxo_woo_wc_order, 'add_meta_box_payment_info' );

		$linxo_woo_cron_job = new Linxo_Woo_Cron_Job();

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$linxo_woo_checkout = new Linxo_Woo_Checkout( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $linxo_woo_checkout, 'enqueue_scripts_styles' );
		$this->loader->add_action( 'woocommerce_blocks_loaded', $linxo_woo_checkout, 'blocks_support' );
		$this->loader->add_action( 'wp_ajax_linxo_woo_check_wc_notice', $linxo_woo_checkout, 'check_wc_notice' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return defined( 'LINXO_WOO_TEXT_DOMAIN' ) ? LINXO_WOO_TEXT_DOMAIN : 'linxo-woo';
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Linxo_Woo_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return defined( 'LINXO_WOO_VERSION' ) ? LINXO_WOO_VERSION : '1.0.0';
	}

}

<?php
class Linxo_Woo_Settings {

	private $test_credentials_class;
	private $create_authorized_account_class;
	private $get_specific_authorized_account_class;
	private $delete_specific_authorized_account_class;
	private $create_alias_class;
	private $delete_alias_class;
	private $get_alias_class;
	private $get_list_aliases_class;
	private $get_list_providers_class;
	private $get_list_authorize_account_class;
	private $webhook_url_class;
	
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		
		$this->test_credentials_class					= new Linxo_Woo_Test_Credentials();
		$this->create_authorized_account_class			= new Linxo_Woo_Create_Authorized_Account();
		$this->get_specific_authorized_account_class	= new Linxo_Woo_Get_Specific_Authorized_Account();
		$this->delete_specific_authorized_account_class	= new Linxo_Woo_Delete_Specific_Authorized_Account();
		$this->create_alias_class						= new Linxo_Woo_Create_Alias();
		$this->delete_alias_class						= new Linxo_Woo_Delete_Alias();
		$this->get_alias_class							= new Linxo_Woo_Get_Alias();
		$this->get_list_aliases_class					= new Linxo_Woo_Get_List_Aliases();
		$this->get_list_providers_class					= new Linxo_Woo_Get_List_Providers();
		$this->get_list_authorize_account_class			= new Linxo_Woo_Get_List_Authorized_Account();
		$this->webhook_url_class						= new Linxo_Woo_Webhook_Url();
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts_styles( $hook_suffix ) {

		if ( $hook_suffix == 'toplevel_page_linxo-woo-settings' ) {

			$admin_main_settings_assets = include( LINXO_WOO_PLUGIN_PATH . 'public/assets/build/admin-main-settings.asset.php' );
			wp_enqueue_style( 'linxo_woo_admin_main_settings', LINXO_WOO_PLUGIN_URL . 'public/assets/build/admin-main-settings.css', array(), $admin_main_settings_assets['version'], 'all' );
			wp_enqueue_script( 'linxo_woo_admin_main_settings', LINXO_WOO_PLUGIN_URL . 'public/assets/build/admin-main-settings.js', $admin_main_settings_assets['dependencies'], $admin_main_settings_assets['version'], true );
			wp_localize_script( 'linxo_woo_admin_main_settings', 'LINXO_WOO_ADMIN_MAIN_SETTINGS_DATA', array(
				'ajaxUrl'   	=> admin_url( 'admin-ajax.php' ),
				'nonce'     	=> wp_create_nonce( 'linxo_woo_ajax_nonce' ),
				'textDomain'	=> LINXO_WOO_TEXT_DOMAIN
			));
		}

	}
		
	/**
	 * add_settings_menu
	 *
	 * @return void
	 */
	public function add_settings_menu() {
		add_menu_page(
            esc_html(__('Linxo Connect Settings', 'linxo-woo')),
            esc_html(__('Linxo Connect', 'linxo-woo')),
			'manage_options',
			'linxo-woo-settings',
			array( $this, 'render_settings_page' ),
			LINXO_WOO_PLUGIN_URL . 'public/assets/svg/logo-menu.svg',
			56
		);
	}
	
	/**
	 * render_settings_page
	 *
	 * @return void
	 */
	public function render_settings_page() {

		$current_language							= substr( get_user_locale(), 0, 2 );
		$header_download_pdf						= file_exists( LINXO_WOO_PLUGIN_PATH . 'public/assets/pdf/readme_'.$current_language.'.pdf' ) ? LINXO_WOO_PLUGIN_URL . 'public/assets/pdf/readme_'.$current_language.'.pdf' : LINXO_WOO_PLUGIN_URL . 'public/assets/pdf/readme_en.pdf';
		$header_contact_support						= $current_language == 'fr' ? 'https://oxlin.zendesk.com/hc/fr-fr/requests/new' : 'https://oxlin.zendesk.com/hc/en-us/requests/new';

		$tabs_array									= $this->get_tabs_array();
		$page_slug									= isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';
		$active_tab									= isset( $_GET[ 'tab' ] ) ? sanitize_text_field( $_GET[ 'tab' ] ) : key($tabs_array);

		$steps_image 								= file_exists( LINXO_WOO_PLUGIN_PATH . 'public/assets/svg/steps/steps_'.$current_language.'.svg' ) ? LINXO_WOO_PLUGIN_URL . 'public/assets/svg/steps/steps_'.$current_language.'.svg' : LINXO_WOO_PLUGIN_URL . 'public/assets/svg/steps/steps_en.svg';

		$account_demo_mode							= linxo_woo_get_option('account_demo_mode');
		$account_client_id							= linxo_woo_get_option('account_client_id');
		$account_client_secret						= linxo_woo_get_option('account_client_secret');
		$account_client_id_demo						= linxo_woo_get_option('account_client_id_demo');
		$account_client_secret_demo					= linxo_woo_get_option('account_client_secret_demo');
		
		$iban_type_company							= $this->create_authorized_account_class::LINXO_WOO_TYPE_COMPANY;
		$iban_type_person							= $this->create_authorized_account_class::LINXO_WOO_TYPE_PERSON;
		$iban_countries 							= linxo_woo_get_countries();
		
		$log_files									= linxo_woo_get_log_files();
		$advanced_enable_logs						= linxo_woo_get_option('advanced_enable_logs');
		$advanced_payment_type						= linxo_woo_get_option('advanced_payment_type');
		$advanced_manual_entry_page_display			= linxo_woo_get_option('advanced_manual_entry_page_display');
		$advanced_alias_storage_enabled				= linxo_woo_get_option('advanced_alias_storage_enabled');

		$statuses_authorized_status_select			= linxo_woo_get_statuses('statuses_authorized_status');
		$statuses_captured_status_select			= linxo_woo_get_statuses('statuses_captured_status');
		$statuses_cancelled_status_select			= linxo_woo_get_statuses('statuses_cancelled_status');
		$statuses_error_status_select				= linxo_woo_get_statuses('statuses_error_status');
		$statuses_authorized_status					= linxo_woo_get_option('statuses_authorized_status');
		$statuses_captured_status					= linxo_woo_get_option('statuses_captured_status');
		$statuses_cancelled_status					= linxo_woo_get_option('statuses_cancelled_status');
		$statuses_error_status						= linxo_woo_get_option('statuses_error_status');

		require_once LINXO_WOO_PLUGIN_PATH . 'admin/templates/page-settings.php';
	}

	/**
	 * Save settings
	 */
	public function save_settings() {

		if ( isset( $_POST['_linxo_woo_admin_nonce'] ) && current_user_can( 'manage_options' ) ) {

			if ( wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['_linxo_woo_admin_nonce'] ) ), 'linxo_woo_admin_custom_settings' ) ) {

				$data_to_save	= array();
				$notice			= array(
					'classes'	=> 'notice-success',
					'msg'		=> esc_html__( 'Settings saved successfully.', 'linxo-woo' ),
				);

				if ( isset($_POST['linxo_woo_account_test']) ) {

					$demo_mode			= isset( $_POST['linxo_woo_account_demo_mode'] ) ? sanitize_text_field( $_POST['linxo_woo_account_demo_mode'] ) : linxo_woo_get_default_option('account_demo_mode');
					$client_id			= isset( $_POST['linxo_woo_account_client_id'] ) ? sanitize_text_field( $_POST['linxo_woo_account_client_id'] ) : linxo_woo_get_default_option('account_client_id');
					$client_secret      = isset( $_POST['linxo_woo_account_client_secret'] ) ? sanitize_text_field( $_POST['linxo_woo_account_client_secret'] ) : linxo_woo_get_default_option('account_client_secret');
					$client_id_demo     = isset( $_POST['linxo_woo_account_client_id_demo'] ) ? sanitize_text_field( $_POST['linxo_woo_account_client_id_demo'] ) : linxo_woo_get_default_option('account_client_id_demo');
					$client_secret_demo = isset( $_POST['linxo_woo_account_client_secret_demo'] ) ? sanitize_text_field( $_POST['linxo_woo_account_client_secret_demo'] ) : linxo_woo_get_default_option('account_client_secret_demo');

					$desired_client_id		= $demo_mode === '1' ? $client_id_demo : $client_id;
					$desired_client_secret	= $demo_mode === '1' ? $client_secret_demo : $client_secret;

					$this->test_credentials_class->set_client_id( $desired_client_id );
					$this->test_credentials_class->set_client_secret( $desired_client_secret );
					$test_credentials = $this->test_credentials_class->test_credentials();

					if ( $test_credentials ) {

                        $linxo_woo_get_oauth2_bearer = new Linxo_Woo_Get_OAuth2_Bearer();

                        $linxo_woo_get_oauth2_bearer->get_token($test_credentials);

						if ( wp_get_environment_type() == 'local' ) {
							$webhook_response = true;
						} else {
							$this->webhook_url_class->set_client_id( $desired_client_id );
							$this->webhook_url_class->set_client_secret( $desired_client_secret );
							$unregister_webhook_response = $this->webhook_url_class->unregister_webhook();
							$webhook_response = $this->webhook_url_class->register_webhook();
						}

						if ( $webhook_response ) {

							$data_to_save['linxo_woo_account_demo_mode']			= $demo_mode;
							$data_to_save['linxo_woo_account_client_id']			= $client_id;
							$data_to_save['linxo_woo_account_client_secret']		= $client_secret;
							$data_to_save['linxo_woo_account_client_id_demo']		= $client_id_demo;
							$data_to_save['linxo_woo_account_client_secret_demo']	= $client_secret_demo;

                            $notice['msg'] = esc_html(__( 'The credentials are valid and the settings have been successfully saved.', 'linxo-woo' ));

						} else {

							$notice['classes']	= 'error';
							$notice['msg']		= esc_html(__( 'Please try again, webhook cannot be saved.', 'linxo-woo' ));
						}

					} else {

						$notice['classes']	= 'error';
						$notice['msg']		= esc_html(__( 'Please verify your credentials.', 'linxo-woo' ));
					}

				} elseif ( isset($_POST['linxo_woo_iban_submit']) ) {

					$iban_company_name                    = isset( $_POST['linxo_woo_iban_company_name'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_company_name'] ) : linxo_woo_get_default_option('iban_company_name');
					$iban_company_national_identification = isset( $_POST['linxo_woo_iban_company_national_identification'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_company_national_identification'] ) : linxo_woo_get_default_option('iban_company_national_identification');
					$iban_company_country                 = isset( $_POST['linxo_woo_iban_company_country'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_company_country'] ) : linxo_woo_get_default_option('iban_company_country');
					$iban_company_iban                    = isset( $_POST['linxo_woo_iban_company_iban'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_company_iban'] ) : linxo_woo_get_default_option('iban_company_iban');
					$iban_company_company_name            = isset( $_POST['linxo_woo_iban_company_company_name'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_company_company_name'] ) : linxo_woo_get_default_option('iban_company_company_name');
					$iban_person_firstname                = isset( $_POST['linxo_woo_iban_person_firstname'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_person_firstname'] ) : linxo_woo_get_default_option('iban_person_firstname');
					$iban_person_surname                  = isset( $_POST['linxo_woo_iban_person_surname'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_person_surname'] ) : linxo_woo_get_default_option('iban_person_surname');
					$iban_person_birth_date               = isset( $_POST['linxo_woo_iban_person_birth_date'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_person_birth_date'] ) : linxo_woo_get_default_option('iban_person_birth_date');
					$iban_person_birth_city               = isset( $_POST['linxo_woo_iban_person_birth_city'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_person_birth_city'] ) : linxo_woo_get_default_option('iban_person_birth_city');
					$iban_person_birth_country            = isset( $_POST['linxo_woo_iban_person_birth_country'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_person_birth_country'] ) : linxo_woo_get_default_option('iban_person_birth_country');
					$iban_person_iban                     = isset( $_POST['linxo_woo_iban_person_iban'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_person_iban'] ) : linxo_woo_get_default_option('iban_person_iban');
					$iban_person_name                     = isset( $_POST['linxo_woo_iban_person_name'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_person_name'] ) : linxo_woo_get_default_option('iban_person_name');
					$iban_type                            = isset( $_POST['linxo_woo_iban_type'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_type'] ) : linxo_woo_get_default_option('iban_type');

					$this->create_authorized_account_class->set_company_name( $iban_company_name );
					$this->create_authorized_account_class->set_company_national_identification( $iban_company_national_identification );
					$this->create_authorized_account_class->set_company_country( $iban_company_country );
					$this->create_authorized_account_class->set_company_iban( $iban_company_iban );
					$this->create_authorized_account_class->set_company_company_name( $iban_company_company_name );
					$this->create_authorized_account_class->set_person_firstname( $iban_person_firstname );
					$this->create_authorized_account_class->set_person_surname( $iban_person_surname );
					$this->create_authorized_account_class->set_person_birth_date( $iban_person_birth_date );
					$this->create_authorized_account_class->set_person_birth_city( $iban_person_birth_city );
					$this->create_authorized_account_class->set_person_birth_country( $iban_person_birth_country );
					$this->create_authorized_account_class->set_person_iban( $iban_person_iban );
					$this->create_authorized_account_class->set_person_name( $iban_person_name );
					$this->create_authorized_account_class->set_type( $iban_type );
					$response = $this->create_authorized_account_class->add_account();

					if ( $response ) {

						$this->create_alias_class->set_user_reference( sprintf('M-%s', md5(linxo_woo_get_client_id())) );
						$this->create_alias_class->set_label( $response->identification->name );
						$this->create_alias_class->set_schema( $response->identification->schema );
						$this->create_alias_class->set_iban( $response->identification->iban );
						$alias_response = $this->create_alias_class->add_alias();

						if ( $alias_response ) {
							
							$notice['msg'] = esc_html__( 'Account successfully added.', 'linxo-woo' );
							$data_to_save['linxo_woo_iban_active_account'] = $alias_response->id;

						} else {

							$notice['classes']	= 'error';
							$notice['msg']		= esc_html__( 'Please try again.', 'linxo-woo' );
						}

					} else {

						$notice['classes']	= 'error';
						$notice['msg']		= esc_html__( 'Please try again.', 'linxo-woo' );
					}

				} elseif ( isset($_POST['linxo_woo_iban_delete']) ) {

					$account_id = isset( $_POST['linxo_woo_iban_delete'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_delete'] ) : linxo_woo_get_default_option('iban_delete');
					$this->delete_alias_class->set_alias_id( $account_id );
					$response = $this->delete_alias_class->delete_alias();

					if ( $response ) {
						$authorize_account = isset( $_POST['linxo_woo_authorize_account_id'] ) ? sanitize_text_field( $_POST['linxo_woo_authorize_account_id'] ) : linxo_woo_get_default_option('authorize_account_id');
                        $this->delete_specific_authorized_account_class->set_account_id($authorize_account);
                        $response_delete_authorize_account = $this->delete_specific_authorized_account_class->delete_account();

                        if ($response_delete_authorize_account) {
                            if (linxo_woo_get_default_alias() == $account_id) {
                                $data_to_save['linxo_woo_iban_active_account'] = linxo_woo_first_alias_as_default();
                            }
                        } else {
                            $notice['classes'] = 'error';
                            $notice['msg'] = esc_html__('Please try again.', 'linxo-woo');
                        }

					} else {
						
						$notice['classes']	= 'error';
						$notice['msg']		= esc_html(__( 'Please try again.', 'linxo-woo' ));
					}

				} elseif ( isset($_POST['linxo_woo_iban_default']) ) {

					$account_id = isset( $_POST['linxo_woo_iban_default'] ) ? sanitize_text_field( $_POST['linxo_woo_iban_default'] ) : linxo_woo_get_default_option('iban_default');

					$data_to_save['linxo_woo_iban_active_account'] = $account_id;
					
				} elseif ( isset($_POST['linxo_woo_advanced_submit']) ) {

					$advanced_enable_logs               = isset( $_POST['linxo_woo_advanced_enable_logs'] ) ? sanitize_text_field( $_POST['linxo_woo_advanced_enable_logs'] ) : linxo_woo_get_default_option('advanced_enable_logs');
					$advanced_payment_type              = isset( $_POST['linxo_woo_advanced_payment_type'] ) ? sanitize_text_field( $_POST['linxo_woo_advanced_payment_type'] ) : linxo_woo_get_default_option('advanced_payment_type');
					$advanced_manual_entry_page_display = isset( $_POST['linxo_woo_advanced_manual_entry_page_display'] ) ? sanitize_text_field( $_POST['linxo_woo_advanced_manual_entry_page_display'] ) : linxo_woo_get_default_option('advanced_manual_entry_page_display');
					$advanced_alias_storage_enabled     = isset( $_POST['linxo_woo_advanced_alias_storage_enabled'] ) ? sanitize_text_field( $_POST['linxo_woo_advanced_alias_storage_enabled'] ) : linxo_woo_get_default_option('advanced_alias_storage_enabled');

					$data_to_save['linxo_woo_advanced_enable_logs']					= $advanced_enable_logs;
					$data_to_save['linxo_woo_advanced_payment_type'] 				= $advanced_payment_type;
					$data_to_save['linxo_woo_advanced_manual_entry_page_display']	= $advanced_manual_entry_page_display;
					$data_to_save['linxo_woo_advanced_alias_storage_enabled'] 		= $advanced_alias_storage_enabled;

				} elseif ( isset($_POST['linxo_woo_statuses_submit']) ) {

					$statuses_authorized_status = isset( $_POST['linxo_woo_statuses_authorized_status'] ) ? sanitize_text_field( $_POST['linxo_woo_statuses_authorized_status'] ) : linxo_woo_get_default_option('statuses_authorized_status');
					$statuses_captured_status   = isset( $_POST['linxo_woo_statuses_captured_status'] ) ? sanitize_text_field( $_POST['linxo_woo_statuses_captured_status'] ) : linxo_woo_get_default_option('statuses_captured_status');
					$statuses_cancelled_status  = isset( $_POST['linxo_woo_statuses_cancelled_status'] ) ? sanitize_text_field( $_POST['linxo_woo_statuses_cancelled_status'] ) : linxo_woo_get_default_option('statuses_cancelled_status');
					$statuses_error_status      = isset( $_POST['linxo_woo_statuses_error_status'] ) ? sanitize_text_field( $_POST['linxo_woo_statuses_error_status'] ) : linxo_woo_get_default_option('statuses_error_status');

					$data_to_save['linxo_woo_statuses_authorized_status'] 	= $statuses_authorized_status;
					$data_to_save['linxo_woo_statuses_captured_status'] 	= $statuses_captured_status;
					$data_to_save['linxo_woo_statuses_cancelled_status']	= $statuses_cancelled_status;
					$data_to_save['linxo_woo_statuses_error_status']		= $statuses_error_status;

				}

				foreach ( $data_to_save as $data_id => $data_value ) {
					update_option( $data_id, $data_value, false );
				}

				add_action( 'admin_notices', function() use ( $notice ) {
					echo '<div class="notice ' . esc_attr($notice['classes']) . '"><p><strong>' . esc_html($notice['msg']) . '</strong></p></div>';
				});

			} else {

					echo '<div class="notice error"><p><strong>' . esc_html__( 'Please try again.', 'linxo-woo' ) . '</strong></p></div>';
				add_action( 'admin_notices', function(){	
				});
			}
		}
	}

	/**
	 * Get the content of a log file with ajax
	 */
	public function get_log_file_content() {

		$nonce = isset($_POST['nonce']) ? sanitize_text_field( wp_unslash ( $_POST['nonce'] ) ) : '';
		if( ! wp_verify_nonce( $nonce, 'linxo_woo_ajax_nonce' ) ) {
			wp_send_json_error();
		}

		$files = linxo_woo_get_log_files();
		if ( empty( $files ) ) {
			wp_send_json_error( esc_html__( 'No log files found!', 'linxo-woo' ) );
		}

		$files = array_filter( $files, function( $file_name ) {
			return strpos( $file_name, 'linxo-woo-' . wp_date( 'Y-m' ) ) !== false;
		});

		$content = '';

		if ( !empty( $files ) && is_array($files) ) {

			$files = array_reverse( $files );
	
			foreach ( $files as $file_name ) {
	
				$file_path	= linxo_woo_get_log_dir() . $file_name;
				$file_exist	= file_exists( $file_path );

				if ( $file_exist ) {
					$content .= file_get_contents($file_path);
				}
			}
		}

		wp_send_json_success( $content );
	}

	/**
	 * Redirect from WC payment page to custom settings page
	 */
	public function maybe_redirect_to_onboarding() {

		if ( wp_doing_ajax() || ! current_user_can( 'manage_woocommerce' ) ) {
			return false;
		}

		$params = array(
			'page'    => 'wc-settings',
			'tab'     => 'checkout',
			'section' => 'linxo_woo'
		);

		$is_linxo_woo_section	= count( $params ) === count( array_intersect_assoc( $_GET, $params ) );

		if ( $is_linxo_woo_section ) {

			$args = array(
				'page' => 'linxo-woo-settings'
			);

			wp_safe_redirect( admin_url( add_query_arg( $args, 'admin.php' ) ) );
			exit;
		}

	}

	/**
	 * Array contains the tabs of the main settings page
	 */
	private function get_tabs_array() {

		return array(
			'presentation' => array(
				'title' => esc_html(__( 'Introduction', 'linxo-woo' ))
			),
			'account' => array(
				'title' => esc_html(__( 'My account', 'linxo-woo' ))
			),
			'iban' => array(
				'title' => esc_html(__( 'Beneficiaries accounts', 'linxo-woo' ))
			),
			'advanced' => array(
				'title' => esc_html(__( 'Advanced settings', 'linxo-woo' ))
			),
			'statuses' => array(
				'title' => esc_html(__( 'Order Statuses', 'linxo-woo' ))
			),
			'faq' => array(
				'title' => esc_html(__( 'FAQ', 'linxo-woo' ))
			)
		);
	}

}
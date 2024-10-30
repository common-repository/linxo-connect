<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linxo.com/
 * @since      1.0.0
 *
 * @package    Linxo_Woo
 * @subpackage Linxo_Woo/admin
 */
class Linxo_Woo_Cron_Job {

	/**
	 * The taxonomy.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $taxonomy    The taxonomy where you want to put the image.
	 * @var      array    $taxonomy    The taxonomies where you want to put the image.
	 */
	private $taxonomy;
	
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {

		add_filter('cron_schedules', [$this, 'crons_registrations'] );

		$crons = self::linxo_woo_crons_list();
		
		foreach ( $crons as $cron_name => $cron_settings ) {
			add_action( 'linxo_woo_'. $cron_name .'_hook', array($this, 'crons_scripts') );
		}
		
		add_action('wp', [$this, 'linxo_woo_cron_events'] );
		
	}
	
	/**
	 * List of all crons
	 *
	 * @since    1.0.0
	 * @return array
	 */
	public function linxo_woo_crons_list():array {
		return array(
			/*
			'exemple' => array(
				"file_path" => "admin/cron/exemple.php",
				'interval' 	=> HOUR_IN_SECONDS * 24,
				'display' 	=> esc_html__( 'Exemple of description', 'linxo-woo' )
			)
			*/
		);
	}

	/**
	* This function allows you to define the recurrence of the cron task for user payments.
	*
	* @since    1.0.0
	*/
    public function crons_registrations($schedules) {
		$crons = self::linxo_woo_crons_list();
		foreach ( $crons as $cron_name => $cron_settings ) {
			$schedules[ $cron_name ] = array(
				'interval' => $cron_settings['interval'], 
				'display'  => $cron_settings['display']
			);
		}
		return $schedules;
    }
	
	/**
	 * Include crons scripts
	 *
	 * @since    1.0.0
	 * @param  mixed $cron_name
	 * @return void
	 */
	public function crons_scripts( $cron_name ) {
		$crons = self::linxo_woo_crons_list();
		$is_cron_job = true;
		include plugin_dir_path( dirname( __FILE__ ) ) . $crons[$cron_name]['file_path'];
	}

	/**
	* This function allows you to start the next cron job.
	*
	* @since    1.0.0
	*/
    public function linxo_woo_cron_events() {
		$crons = self::linxo_woo_crons_list();
		foreach ($crons as $cron_name => $cron_settings) {
			if ( ! wp_next_scheduled( 'linxo_woo_'. $cron_name .'_hook', array($cron_name) ) ) {
				wp_schedule_event( time(), $cron_name, 'linxo_woo_'. $cron_name .'_hook', array($cron_name) );
			}
		}
    }

}
